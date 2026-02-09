import { db } from "./firebase";
import { collection, addDoc } from "firebase/firestore";

// Esta función se ejecutará al pulsar un botón
window.testFirestore = async function () {
  try {
    await addDoc(collection(db, "test"), {
      mensaje: "Firestore funciona 🎉",
      createdAt: new Date(),
    });

    alert("Documento creado en Firestore");
  } catch (error) {
    console.error(error);
    alert("Error, mira la consola");
  }
};
