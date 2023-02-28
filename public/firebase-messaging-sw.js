importScripts(
    "https://www.gstatic.com/firebasejs/9.2.0/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/9.2.0/firebase-messaging-compat.js"
);

const firebaseConfig = {
    apiKey: "AIzaSyCc2Wp7mme0uygYd1Wfsp6uiqolTjkkCE8",
    authDomain: "sipmm-cdd60.firebaseapp.com",
    projectId: "sipmm-cdd60",
    storageBucket: "sipmm-cdd60.appspot.com",
    messagingSenderId: "942407023125",
    appId: "1:942407023125:web:b8d0b15e4cf8d799646c1c",
    measurementId: "G-071FFRJQH0",
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
        badge: payload.notification.badge,
    };
    self.registration.showNotification(notificationTitle, notificationOptions);
});
self.addEventListener("push", (event) => {
    const data = event.data.json();
    const title = data.notification.title;
    const options = {
        body: data.notification.body,
        icon: data.notification.icon,
        badge: data.notification.badge,
    };
    event.waitUntil(self.registration.showNotification(title, options));
});
