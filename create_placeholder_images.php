<?php
// Create placeholder images for missing files

$images = [
    'storage/app/public/news_images/2.jpg',
    'storage/app/public/news_images/5.JPG',
    'storage/app/public/donation_images/2.jpg',
];

foreach ($images as $imagePath) {
    // Create a 800x600 placeholder image
    $width = 800;
    $height = 600;
    
    // Create image
    $image = imagecreatetruecolor($width, $height);
    
    // Create colors
    $bgColor = imagecolorallocate($image, 100, 150, 200); // Light blue background
    $textColor = imagecolorallocate($image, 255, 255, 255); // White text
    $borderColor = imagecolorallocate($image, 50, 100, 150); // Darker blue border
    
    // Fill background
    imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
    
    // Draw border
    imagerectangle($image, 5, 5, $width-6, $height-6, $borderColor);
    
    // Add text
    $filename = basename($imagePath);
    $text = "Placeholder: $filename";
    
    // Calculate text position (centered)
    $font = 5; // Built-in font
    $textWidth = imagefontwidth($font) * strlen($text);
    $textHeight = imagefontheight($font);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    // Draw text
    imagestring($image, $font, $x, $y, $text, $textColor);
    
    // Add smaller subtitle
    $subtext = "Image not available";
    $subtextWidth = imagefontwidth($font) * strlen($subtext);
    $subtextX = ($width - $subtextWidth) / 2;
    $subtextY = $y + $textHeight + 10;
    imagestring($image, $font, $subtextX, $subtextY, $subtext, $textColor);
    
    // Save image
    imagejpeg($image, $imagePath, 85);
    
    // Free memory
    imagedestroy($image);
    
    echo "Created placeholder: $imagePath\n";
}

echo "All placeholder images created successfully!\n";