<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Help - Support</title>
    <link rel="stylesheet" href="getHelp.css">
</head>
<body>
    <div class="container">
        <button onclick="goBack()" class="back-btn">⬅ Back to Home</button>
        <h2>Get Help & Support</h2>
        
        <!-- FAQ Section -->
        <div class="faq">
            <h3 onclick="toggleFaq(0)">❓ How do I reset my password?</h3>
            <p style="display: none;">Go to Settings > Account > Change Password, enter a new password, and confirm.</p>

            <h3 onclick="toggleFaq(1)">❓ How can I contact customer support?</h3>
            <p style="display: none;">You can reach us via email at support@example.com or call +123-456-7890.</p>
        </div>

        <!-- Contact Form -->
        <h3>📩 Contact Support</h3>
        <form class="contact-form" onsubmit="sendHelpRequest(event)">
            <input type="text" id="name" placeholder="Your Name" required>
            <input type="email" id="email" placeholder="Your Email" required>
            <textarea id="message" rows="4" placeholder="Describe your issue..." required></textarea>
            <button type="submit">Submit Request</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
