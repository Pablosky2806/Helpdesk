import { auth, provider } from "./firebase";
import { onAuthStateChanged, signOut } from "firebase/auth";

import {
    createUserWithEmailAndPassword,
    signInWithEmailAndPassword,
    signInWithPopup
} from "firebase/auth";

async function sendTokenToLaravel(user) {
    const idToken = await user.getIdToken();

    const response = await fetch("/firebase/verify", {
    method: "POST",
    credentials: "same-origin", // 👈 AÑADE ESTO
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    body: JSON.stringify({
        token: idToken
    })
});

    return await response.json();
}

document.addEventListener("DOMContentLoaded", () => {

    // Detectar estado de autenticación
onAuthStateChanged(auth, (user) => {
    if (user) {
        console.log("Usuario logueado:", user);

        alert("Bienvenido " + user.email);

        // Aquí luego ocultaremos el login
    } else {
        console.log("No hay usuario logueado");
    }
});


    // Registro
    const registerBtn = document.getElementById("register-btn");
    if (registerBtn) {
        registerBtn.addEventListener("click", () => {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            createUserWithEmailAndPassword(auth, email, password)
    .then(async (userCredential) => {
        const user = userCredential.user;

        await sendTokenToLaravel(user);

        window.location.href = "/dashboard";
    })
                .catch((error) => {
                    alert(error.message);
                });
        });
    }

    // Login email
    const loginBtn = document.getElementById("login-btn");
    if (loginBtn) {
        loginBtn.addEventListener("click", () => {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            signInWithEmailAndPassword(auth, email, password)
    .then(async (userCredential) => {
        const user = userCredential.user;

        await sendTokenToLaravel(user);

        window.location.href = "/dashboard";
    })
                .catch((error) => {
                    alert(error.message);
                });
        });
    }

    // Login Google
    const googleBtn = document.getElementById("google-btn");
    if (googleBtn) {
        googleBtn.addEventListener("click", () => {
            signInWithPopup(auth, provider)
    .then(async (result) => {
        const user = result.user;

        await sendTokenToLaravel(user);

        window.location.href = "/dashboard";
    })
                .catch((error) => {
                    alert(error.message);
                });
        });
    }

    // Logout
const logoutBtn = document.getElementById("logout-btn");
if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
        signOut(auth)
            .then(() => {
                alert("Sesión cerrada");
            })
            .catch((error) => {
                alert(error.message);
            });
    });
}


});
