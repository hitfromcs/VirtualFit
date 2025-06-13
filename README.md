Hi! Im Arham Ahmed, and VirtualFit is a project I came up with as part of my final year project in Computer Science. It brings together my interest in tech and design to solve a real problem in online shopping.



# VirtualFit - Virtual Try-On Clothing Website

VirtualFit is a web-based clothing store where users can try on outfits using a 3D virtual model. The goal of this project is to make online shopping easier by helping people visualize how clothes will look on them before they buy.

Users can sign up, choose body preferences like gender, size, and skin tone, and preview how different clothing items will look. The 3D model changes based on what you pick, giving a more realistic feel to online shopping.

The website also includes basic cart and checkout functionality, and all major pages like home, product details, and try-on are already built.

This project is mostly static but includes some backend functionality like user registration and login using PHP and MySQL. A future version may include admin controls and a complete order system.

---

## How to Run This Project Locally

To run this project on your computer:

1. Make sure XAMPP is installed and Apache and MySQL are running.
2. Copy the entire folder into your `XAMPP/htdocs` directory.
3. Open your browser and go to `http://localhost/VirtualFit/signup.php` (or whichever page you want to test).

If you want to use the contact form (PHP Mailer), you’ll need to add your own email credentials so emails can be sent properly. The website still works without this setup, so it's completely optional.

If you do want to set up email sending:
- Open the project in VS Code.
- Press `Ctrl + Shift + F` to search the whole project.
- Look for `arhamahmed8699@gmail.com` and `password`.
- Replace both with your own Gmail and your generated app password.

You can generate an app-specific password here: [https://myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)

---

## Tools Used

- HTML, CSS, JavaScript
- Figma (Wireframe, UI/UX)
- PHP (for backend and form and email handling)
- MySQL (via XAMPP)
- Blender (Used Charmorph Library for 3D models)
- Three.js (for the 3D virtual try-on room)
- VS Code (development)
- phpMyAdmin (database management)

---

## Note

This is a student project built for educational purposes. All 3D models and logic are preloaded and handled on the client side for simplicity. The focus was on blending a real shopping experience with an interactive virtual interface.

Feel free to explore, clone, or improve it. Dont forget to give your credits to Virtual Fit and CharMorph. Thanks for checking it out!

Special thanks to CharMorph for their amazing 3D Model Library. You can check it out here: https://github.com/Upliner/CharMorph
