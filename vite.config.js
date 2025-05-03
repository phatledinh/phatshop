import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});

// Remove-Item storage\logs\laravel.log
// php artisan make:migration create_users_table
// php artisan make:model Product
// php artisan make:controller ProductController
// NGUYEN VAN A	9704 0000 0000 0018	03/07	OTP
// 9704198526191432198 NGUYEN VAN A 07/15 123456
