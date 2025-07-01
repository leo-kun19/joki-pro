<!DOCTYPE html>
<html data-theme="halloween" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#007bff">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? config('APP_NAME') }} | {{ env('APP_NAME') }}</title>

  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
  <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">

  @livewireStyles
  @filamentStyles
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <main>
      @livewire('notifications')
      @livewire('database-notifications')
      {{ $slot }}
    </main>
  </div>

  @filamentScripts
  @livewireScripts
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@5.10.7/tinymce.min.js"></script>
<script>
  tinymce.init({
    selector: '#editor',
    plugins: 'link image code',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code',
    height: 300
  });
</script>
  <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(reg => {
            console.log('Service Worker registered at:', reg.scope);
            return reg.active ? reg : new Promise(resolve => {
                reg.addEventListener('updatefound', () => {
                    const newSW = reg.installing;
                    newSW.addEventListener('statechange', () => {
                        if (newSW.state === 'activated') resolve(reg);
                    });
                });
            });
        })
        .then(reg => {
            const messaging = firebase.messaging();
            messaging.getToken({
                vapidKey: 'BK-DZDsFl2C0bpMoWLfFboEDFc-XVuwBExDzvsp2FB4wVP_SsMQketgzJd0sNmiEEiIU9Si5waFf8JzYneKxxh0',
                serviceWorkerRegistration: reg
            }).then(token => {
                console.log('FCM Token:', token);
                fetch('/send-token-fcm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ token })
                });
            });

            messaging.onMessage(payload => {
                console.log('Pesan foreground:', payload);
                new Notification(payload.notification.title, {
                    body: payload.notification.body,
                    icon: payload.notification.image || '/logo.png'
                });
            });
        })
        .catch(err => console.error('SW registration failed:', err));
    }
</script>


  <script>
    setInterval(() => {
      fetch('/csrf-token').then(r => r.text()).then(t => {
        document.querySelector('meta[name="csrf-token"]').content = t;
        window.Livewire.findComponents().forEach(c => c.__instance.canonical = t);
      });
    }, 300000);
  </script>

</body>
</html>
