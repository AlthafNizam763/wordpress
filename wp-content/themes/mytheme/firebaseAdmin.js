import admin from 'firebase-admin';
import path from 'path';

// Construct the path to the service account JSON
// You might need to adjust this depending on how you run your application
const serviceAccountPath = process.env.FIREBASE_ADMIN_SERVICE_ACCOUNT_PATH 
  ? path.resolve(process.cwd(), process.env.FIREBASE_ADMIN_SERVICE_ACCOUNT_PATH)
  : null;

if (!admin.apps.length) {
  try {
    if (serviceAccountPath) {
      admin.initializeApp({
        credential: admin.credential.cert(require(serviceAccountPath)),
        // databaseURL: `https://${process.env.NEXT_PUBLIC_FIREBASE_PROJECT_ID}.firebaseio.com` 
        // Uncomment databaseURL if you use Realtime Database
      });
    } else {
      // Fallback for application default credentials if service account path is missing
      admin.initializeApp();
    }
  } catch (error) {
    console.error('Firebase Admin Initialization Error:', error.stack);
  }
}

export const adminAuth = admin.auth();
export const adminDb = admin.firestore();
export const adminStorage = admin.storage();

export default admin;
