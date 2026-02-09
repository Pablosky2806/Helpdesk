import { initializeApp } from "firebase/app";
import { getFirestore } from "firebase/firestore";

const firebaseConfig = {
    apiKey: "TU_API_KEY",
    authDomain: "helpdesk-bf465.firebaseapp.com",
    projectId: "helpdesk-bf465",
    storageBucket: "helpdesk-bf465.appspot.com",
    messagingSenderId: "18276183668",
    appId: "1:18276183668:web:360089478b5907e5b4ab21"
};

const app = initializeApp(firebaseConfig);
export const db = getFirestore(app);
