/** @type {import('tailwindcss').Config} */
tailwind.config = {
    content: ["./.{html}"],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                'rubik' : ["Rubik", "sans-serif"]
            },
            colors: {
                'biruMiaw' : '#86D6F2',
                'putihMiaw': '#F6F1F1',
                'hitamMiaw': '#241f42'
            }
        }
    }
}