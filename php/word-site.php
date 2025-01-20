<?php
// Database configuration
$host = 'sqldb';
$dbname = 'dictionary_db';
$user = 'root';
$password = 'password'; // Use your MySQL password here

// Initialize variables
$word = '';
$definition = '';
$error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['word'])) {
    $word = trim($_GET['word']);

    if (empty($word)) {
        // If the input is empty, reset the state
        $word = '';
        $definition = '';
        $error = '';
    } else {
        // Connect to the database
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch the definition from the database
            $stmt = $conn->prepare("SELECT definition FROM words WHERE word = :word");
            $stmt->bindParam(':word', $word);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $definition = $result['definition'];
            } else {
                $error = "Word not found.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

// Fetch a random set of suggested words from the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch 10 random words from the database
    $stmt = $conn->query("SELECT word FROM words ORDER BY RAND() LIMIT 10");
    $suggestedWords = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // If there's an error, fall back to a default list
    $suggestedWords = ['algorithm', 'byte', 'cache', 'database', 'encryption', 'firmware', 'gateway', 'HTTP', 'IP address', 'Java'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lexicon</title>
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="https://i.ibb.co/jk7YtJc/lexicon.jpg">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: url('https://w.wallhaven.cc/full/we/wallhaven-wez6yq.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            padding: 30px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #27375c;
            margin-bottom: 20px;
            text-shadow: 0 0 10px #27375c, 0 0 20px #27375c;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .sidebar {
            width: 250px; /* Width of the sidebar */
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            padding: 20px;
            backdrop-filter: blur(10px);
        }
        .sidebar h4 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #27375c;
            margin-bottom: 15px;
            text-align: center;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar ul li {
            font-size: 1rem;
            color: #fff;
            padding: 10px;
            margin: 5px 0;
            background: rgba(39, 55, 92, 0.2);
            border-radius: 10px;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .sidebar ul li:hover {
            background: rgba(39, 55, 92, 0.5);
            transform: translateX(5px);
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #27375c;
            padding: 12px;
            font-size: 1rem;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #27375c;
            box-shadow: 0 0 10px #27375c, 0 0 20px #27375c;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 1rem;
            background: #27375c;
            border: none;
            color: #fff;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 0 10px #27375c, 0 0 20px #27375c;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            background: #1c2a4a;
            transform: translateY(-2px);
            box-shadow: 0 0 20px #27375c, 0 0 30px #27375c;
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 0 10px #27375c, 0 0 20px #27375c;
        }
        .result {
            margin-top: 20px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .result.show {
            opacity: 1;
            transform: translateY(0);
        }
        .result h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #27375c;
            margin-bottom: 10px;
        }
        .result p {
            font-size: 1.1rem;
            color: #fff;
            margin: 0;
        }
        .text-danger {
            color: #ff4444;
        }
        .loader {
            display: none;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #27375c;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .suggested-words {
            margin-top: 20px;
            text-align: center;
        }
        .suggested-words h4 {
            font-size: 1.2rem;
            color: #27375c;
            margin-bottom: 10px;
        }
        .suggested-words .word-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .suggested-words .word-list span {
            cursor: pointer;
            padding: 5px 10px;
            background: rgba(39, 55, 92, 0.2);
            border-radius: 5px;
            color: #27375c;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .suggested-words .word-list span:hover {
            background: #27375c;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Sidebar for Suggested Words -->
    <div class="sidebar">
        <h4>Suggested Words</h4>
        <ul>
            <?php foreach ($suggestedWords as $suggestedWord): ?>
                <li><?php echo htmlspecialchars($suggestedWord); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="container">
        <h1>Lexiconn v2</h1>
        <form method="GET" action="" onsubmit="showLoader()">
            <div class="input-group">
                <input type="text" name="word" id="wordInput" class="form-control" placeholder="Enter a word" value="<?php echo htmlspecialchars($word); ?>" oninput="resetState()">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Lookup
                </button>
            </div>
        </form>

        <div class="loader" id="loader"></div>

        <?php if ($definition || $error): ?>
            <div class="result show" id="result">
                <?php if ($definition): ?>
                    <h3><?php echo htmlspecialchars($word); ?></h3>
                    <p><?php echo htmlspecialchars($definition); ?></p>
                <?php elseif ($error): ?>
                    <p class="text-danger"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
            document.getElementById('result').classList.remove('show');
        }

        function resetState() {
            const input = document.querySelector('input[name="word"]');
            if (input.value.trim() === '') {
                // Hide the result section if the input is empty
                document.getElementById('result').classList.remove('show');
            }
        }

        // Function to set the word in the input field and submit the form
        function setWord(word) {
            document.getElementById('wordInput').value = word;
            document.querySelector('form').submit();
        }

        // Simulate a delay for demonstration purposes
        setTimeout(() => {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('result').classList.add('show');
        }, 1000);
    </script>
</body>
</html>
