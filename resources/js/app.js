import './bootstrap';
import 'flowbite';
// import 'livewire-vite-plugin/resources/js/livewire-hot-reload';

import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

const firebaseConfig = {
  apiKey: "AIzaSyCSpdDfw0_6KDqq_WAs5AGtFjS0iVYSopg",
  authDomain: "lms-mysunrise.firebaseapp.com",
  projectId: "lms-mysunrise",
  storageBucket: "lms-mysunrise.appspot.com",
  messagingSenderId: "126805896019",
  appId: "1:126805896019:web:baedf52c3ca7b46c6dcfa6"
};

// Inisialisasi Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Fungsi untuk inisialisasi FCM
function initFirebaseMessagingRegistration() {
  getToken(messaging, { 
    vapidKey: 'BK-DZDsFl2C0bpMoWLfFboEDFc-XVuwBExDzvsp2FB4wVP_SsMQketgzJd0sNmiEEiIU9Si5waFf8JzYneKxxh0' // Ganti dengan VAPID key Anda
  })
  .then((currentToken) => {
    if (currentToken) {
      console.log('FCM Token:', currentToken);
      // Kirim token ke backend disini
    } else {
      console.log('Tidak ada token yang tersedia. Pastikan Anda telah memberikan izin');
    }
  })
  .catch((err) => {
    console.error('Error saat mendapatkan token:', err);
  });

  // Handler untuk pesan yang diterima saat aplikasi aktif
  onMessage(messaging, (payload) => {
    console.log('Pesan diterima:', payload);
    // Tampilkan notifikasi disini
  });
}

// Daftarkan service worker
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/firebase-messaging-sw.js')
    .then((registration) => {
      console.log('Service Worker terdaftar dengan scope:', registration.scope);
      initFirebaseMessagingRegistration();
    })
    .catch((err) => {
      console.error('Pendaftaran Service Worker gagal:', err);
    });
}