<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Push Notification Testing</title>

    {{-- Push notification and service-worker --}}
    <script src="{{ asset('service-worker.js') }}"></script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>

</head>

<body>

    <h1>Welcome to Server Worker</h1>

    <script>
        const beamsClient = new PusherPushNotifications.Client({
          instanceId: '8b3b569d-f1f8-4b0d-a20a-ef91aaf64e0a',
        });

        beamsClient.start()
          .then(() => beamsClient.addDeviceInterest('hello'))
          .then(() => console.log('Successfully registered and subscribed!'))
          .catch(console.error);
      </script>


{{-- curl -H "Content-Type: application/json" \
     -H "Authorization: Bearer 2DEBDC5837F86862EE61D76022AB6345DB5497E7C17B337AFF3B2F5A8A9836C5" \
     -X POST "https://8b3b569d-f1f8-4b0d-a20a-ef91aaf64e0a.pushnotifications.pusher.com/publish_api/v1/instances/8b3b569d-f1f8-4b0d-a20a-ef91aaf64e0a/publishes" \
     -d '{"interests":["hello"],"web":{"notification":{"title":"Hello","body":"Hello, world!"}}}' --}}

</body>

</html>
