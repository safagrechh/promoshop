<html>
    <head>
        <!-- Add your CSS styles here -->
    </head>
    <body>
        <h1>Commande Details</h1>
        @if ($commande)
            <p>Commande ID: {{ $commande->id }}</p>
            <!-- Access Commande details -->
            <!-- Add more details as needed -->

            <h2>Ordered Items</h2>
            <ul>
               
            </ul>
        @else
            <p>No Commande data available.</p>
        @endif
    </body>
</html>1
