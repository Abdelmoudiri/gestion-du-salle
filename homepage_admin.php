<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HomePage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="bg-gray-700 w-full h-full">
          
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold text-center mb-6">Gérer Votre Salle de Sport</h1>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Tous les Membres</h2>
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nom</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Téléphone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'connect.php';
                        $query = "SELECT ID_Membre, Nom, Prenom, Email, Telephone FROM membres";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['ID_Membre'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Nom'] . " " . $row['Prenom'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Email'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Telephone'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Toutes les Réservations</h2>
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Membre</th>
                            <th class="border border-gray-300 px-4 py-2">Activité</th>
                            <th class="border border-gray-300 px-4 py-2">Date</th>
                            <th class="border border-gray-300 px-4 py-2">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT r.ID_Reservation, CONCAT(m.Nom, ' ', m.Prenom) AS Membre, a.Nom_Activite, r.Date_Reservation, r.Statut 
                                  FROM reservations r
                                  JOIN membres m ON r.ID_Membre = m.ID_Membre
                                  JOIN activites a ON r.ID_Activite = a.ID_Activite";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['ID_Reservation'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Membre'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Nom_Activite'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Date_Reservation'] . "</td>";
                            echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Statut'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>
