<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .maintenance-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 90%;
        }
        
        .maintenance-image {
            width: 200px;
            height: 200px;
            object-fit: contain;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            aspect-ratio: 1/1;
            background: #f8f9fa;
            padding: 10px;
        }
        
        .maintenance-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .maintenance-description {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        
        .maintenance-icon {
            font-size: 4rem;
            color: #f39c12;
            margin-bottom: 20px;
        }
        
        .back-soon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .maintenance-container {
                padding: 40px 20px;
            }
            
            .maintenance-title {
                font-size: 2rem;
            }
            
            .maintenance-description {
                font-size: 1rem;
            }
            
            .maintenance-image {
                width: 150px;
                height: 150px;
                aspect-ratio: 1/1;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>
        
        @if($maintainance && $maintainance->image)
            <img src="{{ asset($maintainance->image) }}" alt="Maintenance" class="maintenance-image">
        @endif
        
        <h1 class="maintenance-title">Site Under Maintenance</h1>
        
        <div class="maintenance-description">
            @if($maintainance && $maintainance->description)
                {{ $maintainance->description }}
            @else
                We are currently performing scheduled maintenance to improve your experience. Please check back soon!
            @endif
        </div>
        
        <div class="back-soon">We'll be back soon!</div>
    </div>
</body>
</html>