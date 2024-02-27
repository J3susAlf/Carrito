<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/b1b47db464.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/Chat.css">

</head>

<body>
    <button class="chatbot-toggler">
        <span class="material-symbols-outlined"><i class="fa-solid fa-robot"></i></span>
        <span class=""><i class="fa-solid fa-xmark fa-xl"></i></span>
    </button>
    <div class="chatbot">
        <header>
            <h2>Chatbot</h2>
            <span class="close-btn"><i class="fa-solid fa-xmark fa-xl"></i></span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Escribir...." required></textarea>
            <span id="send-btn" class=""><i class="fa-solid fa-paper-plane"></i></span>
        </div>

    </div>

    <script src="js/Chat.js" defer></script>
</body>

</html>