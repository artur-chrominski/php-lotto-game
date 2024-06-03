<div class="flex min-h-full flex-col justify-center items-center px-6 py-12 lg:px-8" x-data="{ tab: 'sign-in' }">
    <div class="flex space-x-4 mb-8">
        <input id="tab-1" type="radio" name="tab" x-model="tab" value="sign-in" class="hidden">
        <label for="tab-1" class="cursor-pointer py-2 px-4 rounded-lg border border-gray-300 font-medium"
            :class="{ 'bg-indigo-600 text-white': tab === 'sign-in', 'bg-white text-gray-900': tab !== 'sign-in' }">Zaloguj
            się</label>

        <input id="tab-2" type="radio" name="tab" x-model="tab" value="sign-up" class="hidden">
        <label for="tab-2" class="cursor-pointer py-2 px-4 rounded-lg border border-gray-300 font-medium"
            :class="{ 'bg-indigo-600 text-white': tab === 'sign-up', 'bg-white text-gray-900': tab !== 'sign-up' }">Zarejestruj
            się</label>
    </div>

    <div x-show="tab === 'sign-in'" class="w-full sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Zaloguj się na swoje
            konto</h2>
        <?php
        if (isset($_SESSION['login_errors'])) {
            echo "<div class='text-red-600 mb-4'>";
            foreach ($_SESSION['login_errors'] as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
            unset($_SESSION['login_errors']);
        }
        ?>
        <form class="space-y-6 mt-10" action="../api/user/login.php" method="GET">
            <div>
                <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Adres email</label>
                <div class="mt-2">
                    <input id="username" name="username" type="text" autocomplete="username" required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Hasło</label>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Zaloguj
                    się</button>
            </div>
        </form>
    </div>

    <div x-show="tab === 'sign-up'" class="w-full sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Zarejestruj nowe konto
        </h2>
        <?php
        if (isset($_SESSION['signup_errors'])) {
            echo "<div class='text-red-600 mb-4'>";
            foreach ($_SESSION['signup_errors'] as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
            unset($_SESSION['signup_errors']);
        }
        ?>
        <form class="space-y-6 mt-10" action="../api/user/signup.php" method="POST">
            <div>
                <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Nazwa
                    użytkownika</label>
                <div class="mt-2">
                    <input id="username" name="username" type="text" autocomplete="username" required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Hasło</label>
                <div class="mt-2">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-900">Potwierdź
                    hasło</label>
                <div class="mt-2">
                    <input id="confirm-password" name="confirm_password" type="password" autocomplete="new-password"
                        required
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Zarejestruj
                    się</button>
            </div>
        </form>
    </div>
</div>
