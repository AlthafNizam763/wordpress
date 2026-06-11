// Use standard ES modules for Firebase via CDN for the WordPress Frontend
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
import { getFirestore, collection, getDocs, query, orderBy, onSnapshot } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-firestore.js";

const firebaseConfig = {
    apiKey: "AIzaSyB1MksDJBCRdbXfbk_IxCDdnwuWQVw3ot0",
    authDomain: "coffee-spark-ai-barista-ff4a4.firebaseapp.com",
    projectId: "coffee-spark-ai-barista-ff4a4",
    storageBucket: "coffee-spark-ai-barista-ff4a4.firebasestorage.app",
    messagingSenderId: "659251016740",
    appId: "1:659251016740:web:19c4c5e5a09db7550054b1",
    measurementId: "G-233JF3GCGX"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

/**
 * Fetch documents from any Firestore collection
 * @param {string} collectionName - Name of collection (events, courses, projects, etc.)
 * @param {string} sortField - Optional field to sort by (e.g., 'createdAt', 'order')
 * @param {string} sortDirection - 'asc' or 'desc'
 * @returns {Promise<Array>} - Array of document objects
 */
export async function fetchCollection(collectionName, sortField = null, sortDirection = 'asc') {
    try {
        console.log(`Fetching data from ${collectionName}...`);
        
        const colRef = collection(db, collectionName);
        let q = colRef;
        
        if (sortField) {
            q = query(colRef, orderBy(sortField, sortDirection));
        } else {
            q = query(colRef);
        }

        const querySnapshot = await getDocs(q);
        const data = [];
        querySnapshot.forEach((doc) => {
            data.push({ id: doc.id, ...doc.data() });
        });
        
        console.log(`Fetched ${data.length} items from ${collectionName}.`);
        return data;
    } catch (error) {
        console.error(`Error fetching ${collectionName} from Firebase:`, error);
        return [];
    }
}

/**
 * Connect to Firestore database and fetch data from all root-level collections
 * with automatic synchronization.
 * @param {function} callback - Callback function that receives the grouped collections object.
 * @returns {function} - Unsubscribe function to close all listeners.
 */
export function subscribeToAllCollections(callback) {
    const collections = [
        "events",
        "courses",
        "projects",
        "observations",
        "collaborations",
        "news",
        "team_members",
        "changemakers",
        "gallery"
    ];

    const dataStore = {
        events: [],
        courses: [],
        projects: [],
        observations: [],
        collaborations: [],
        news: [],
        team_members: [],
        changemakers: [],
        gallery: []
    };

    const initialLoads = new Set();
    const unsubscribes = [];

    collections.forEach((colName) => {
        const colRef = collection(db, colName);
        const unsubscribe = onSnapshot(colRef, (snapshot) => {
            const list = [];
            snapshot.forEach((doc) => {
                list.push({
                    id: doc.id,
                    ...doc.data()
                });
            });

            // If an 'order' field exists, sort records in ascending order
            const hasOrder = list.some(item => 'order' in item);
            if (hasOrder) {
                list.sort((a, b) => {
                    const valA = a.order !== undefined && a.order !== null ? Number(a.order) : Infinity;
                    const valB = b.order !== undefined && b.order !== null ? Number(b.order) : Infinity;
                    return valA - valB;
                });
            }

            dataStore[colName] = list;
            initialLoads.add(colName);

            // Trigger callback once all collections have initially loaded
            if (initialLoads.size === collections.length) {
                callback({ ...dataStore });
            }
        }, (error) => {
            console.error(`Error in snapshot listener for ${colName}:`, error);
        });

        unsubscribes.push(unsubscribe);
    });

    return () => {
        unsubscribes.forEach(unsub => unsub());
    };
}

// Automatically expose it to the global window object
window.firebaseFetchCollection = fetchCollection;
window.firebaseSubscribeToAllCollections = subscribeToAllCollections;

