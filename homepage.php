<?php
session_start();
include("connect.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$query = "SELECT CONCAT(Nom, ' ', Prenom) AS NomComplet FROM membres WHERE ID_Membre = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_name = $user['NomComplet'] ?? 'Utilisateur';

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

<header class="bg-blue-500 text-white py-4 shadow">
    <div class="container mx-auto flex justify-between items-center px-6">
        <h1 class="text-2xl font-bold text-black"> <span  class="text-white">Bienvenue, Cher Client </span>  <?php echo htmlspecialchars($user_name); ?> </h1>
        <nav>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">Déconnexion</a>
        </nav>
    </div>
</header>
    
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
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['ID_Activite'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Nom_Activite'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Description'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Capacite'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['date_debut'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['date_fin'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Disponibilite'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1 flex space-x-2'>";
                echo "<form method='POST' action='reserver_activite.php?id=". $row['ID_Activite']."' class='inline-block'>
                        <input type='hidden' name='id_activite' value='" . $row['ID_Activite'] . "'>
                        <button type='submit' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'>Réserver</button>
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
                <th class="border border-gray-300 px-4 py-2">Actions</th>

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
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['ID_Reservation'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Membre'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Nom_Activite'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Date_Reservation'] . "</td>";
                echo "<td class='border border-gray-300 px-1 py-1'>" . $row['Statut'] . "</td>";
             
                echo "<td>
                        <form method='POST' action='supprimer_activite.php' class='inline-block'>
                        <input type='hidden' name='id_activite'>
                        <button type='submit' class='bg-red-500 text-white px-1 w-full py-1 rounded hover:bg-red-600'>Supprimer</button>
                        </form>
                      </td>";
                      
              echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>


<!--  -->