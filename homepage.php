<?php
session_start();
include("connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
<div class="bg-white rounded shadow-md p-6">
    <h2 class="text-xl font-bold mb-4">Toutes les Activités</h2>
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nom de l'Activité</th>
                <th class="border border-gray-300 px-4 py-2">Description</th>
                <th class="border border-gray-300 px-4 py-2">Capacité</th>
                <th class="border border-gray-300 px-4 py-2">Date Début</th>
                <th class="border border-gray-300 px-4 py-2">Date Fin</th>
                <th class="border border-gray-300 px-4 py-2">Disponibilité</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT ID_Activite, Nom_Activite, Description, Capacite, date_debut, date_fin, 
                      CASE WHEN Disponibilite = 1 THEN 'Disponible' ELSE 'Non Disponible' END AS Disponibilite 
                      FROM activites";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['ID_Activite'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Nom_Activite'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Description'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Capacite'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['date_debut'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['date_fin'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2'>" . $row['Disponibilite'] . "</td>";
                echo "<td class='border border-gray-300 px-4 py-2 flex space-x-2'>";
                echo "<form method='POST' action='reserver_activite.php' class='inline-block'>
                        <input type='hidden' name='id_activite' value='" . $row['ID_Activite'] . "'>
                        <button type='submit' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'>Réserver</button>
                      </form>";
                echo "<form method='POST' action='modifier_activite.php' class='inline-block'>
                        <input type='hidden' name='id_activite' value='" . $row['ID_Activite'] . "'>
                        <button type='submit' class='bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600'>Modifier</button>
                      </form>";
                echo "<form method='POST' action='supprimer_activite.php' class='inline-block'>
                        <input type='hidden' name='id_activite' value='" . $row['ID_Activite'] . "'>
                        <button type='submit' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>Supprimer</button>
                      </form>";
                
                echo "</td>";
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