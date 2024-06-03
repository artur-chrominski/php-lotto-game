<?php
include_once __DIR__ . '/../api/config/database.php';
include_once __DIR__ . '/../api/objects/draw.php';
date_default_timezone_set('Europe/Warsaw');

$database = new Database();
$db = $database->getConnection();

$draw = new Draw($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number_of_balls = isset($_POST['number_of_balls']) ? intval($_POST['number_of_balls']) : 49;
    $number_of_drawn = isset($_POST['number_of_drawn']) ? intval($_POST['number_of_drawn']) : 6;

    if ($number_of_drawn > $number_of_balls) {
        $error = "Liczba wylosowanych kul nie może być większa niż liczba kul..";
    } else {
        $drawn_numbers = array();
        while (count($drawn_numbers) < $number_of_drawn) {
            $number = rand(1, $number_of_balls);
            if (!in_array($number, $drawn_numbers)) {
                $drawn_numbers[] = $number;
            }
        }
        sort($drawn_numbers);

        $draw->user_id = $_SESSION['id'];
        $draw->numbers = json_encode($drawn_numbers);
        $draw->draw_date = date('Y-m-d H:i:s');

        if ($draw->create()) {
            $success = "Losowanie udane!.";
        } else {
            $error = "Nie można zapisać numerów w bazie.";
        }
    }
}

$draws_stmt = $draw->getDrawsByUserId($_SESSION['id']);
$draws = $draws_stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="flex justify-between items-center p-4 bg-gray-100">
    <div class="text-gray-900 font-bold">
        Zalogowany jako: <?php echo $_SESSION['username']; ?>
    </div>
    <form action="../api/user/logout.php" method="POST">
        <button type="submit" class="text-red-600 hover:text-red-800 focus:outline-none">
            <img src="../src/images/switch.svg" alt="Log out" class="h-8 w-8 text-red-600 hover:text-red-800" />
        </button>
    </form>
</div>

<div class="container">
    <h1 class="text-2xl font-bold">Gra Lotto</h1>
    <form method="post" class="mt-4">
        <div class="mb-6">
            <label for="number-of-balls" class="block text-lg font-medium text-gray-700">Ilość kul</label>
            <input type="number" id="number-of-balls" name="number_of_balls" value="49"
                class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg py-2 px-4">
        </div>
        <div class="mb-6">
            <label for="number-of-drawn" class="block text-lg font-medium text-gray-700">Ilość losowanych kul</label>
            <input type="number" id="number-of-drawn" name="number_of_drawn" value="6"
                class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg py-2 px-4">
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-md text-lg">Losuj</button>
    </form>

    <?php if (isset($error)): ?>
        <div class="mt-4 text-red-600"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="mt-4 text-green-600"><?php echo $success; ?></div>
        <div class="mt-4">Wylosowane numery: <?php echo implode(', ', $drawn_numbers); ?></div>
    <?php endif; ?>

    <h2 class="text-xl font-bold mt-8">Historia losowań</h2>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-md sm:rounded-lg flex justify-center">
                    <table class="min-w-full text-center text-xl font-light">
                        <thead class="border-b bg-indigo-600 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID Losowania</th>
                                <th scope="col" class="px-6 py-4">Nazwa użyykownika</th>
                                <th scope="col" class="px-6 py-4">Wylosowane Numery</th>
                                <th scope="col" class="px-6 py-4">Data losowania</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($draws as $draw): ?>
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                        <?php echo htmlspecialchars($draw['id']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <?php echo htmlspecialchars($draw['username']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-green-500">
                                        <?php echo htmlspecialchars($draw['numbers']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <?php echo htmlspecialchars($draw['draw_date']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>