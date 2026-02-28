// Importaciones necesarias
import { initializeApp } from "firebase/app";
import { getAuth, GoogleAuthProvider } from "firebase/auth";

// Configuración Firebase
const firebaseConfig = {
  apiKey: "AIzaSyATyVyZ5WWXQlLRSDkMNw05Jy8ZPWqCXX8",
  authDomain: "helpdesk-bf465.firebaseapp.com",
  projectId: "helpdesk-bf465",
  storageBucket: "helpdesk-bf465.firebasestorage.app",
  messagingSenderId: "18276183668",
  appId: "1:18276183668:web:360089478b5907e5b4ab21",
  measurementId: "G-DG7TX4GYQP"
};

// Inicializar Firebase
const app = initializeApp(firebaseConfig);

// 🔥 Inicializar Auth
export const auth = getAuth(app);

// 🔥 Proveedor Google
export const provider = new GoogleAuthProvider();
