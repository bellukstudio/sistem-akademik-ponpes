<script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.3/firebase-messaging.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyCc2Wp7mme0uygYd1Wfsp6uiqolTjkkCE8",
        authDomain: "sipmm-cdd60.firebaseapp.com",
        projectId: "sipmm-cdd60",
        storageBucket: "sipmm-cdd60.appspot.com",
        messagingSenderId: "942407023125",
        appId: "1:942407023125:web:b8d0b15e4cf8d799646c1c",
        measurementId: "G-071FFRJQH0"
    };

    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    messaging.requestPermission()
        .then(function() {
            console.log('Permission granted!');
            var token = messaging.getToken();
            return token;
        })
        .then(function(token) {
            // console.log('Token:', token);
            // send the token to your Laravel application
            return fetch('/api/v1/app/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    token: token
                })
            });
        })
        .catch(function(error) {
            console.log('Error:', error);
        });

    messaging.onMessage(function(payload) {
        // console.log('Received message:', payload);
        // handle the notification
        console.log(payload.notification);
        setTimeout(function() {
            toastr.options.closeButton = true;
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 1000;
            toastr.success(payload.notification.body, payload.notification.title);
        }, 3000);
        window.reload();

    });
</script>
