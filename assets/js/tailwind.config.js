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
                'biruMiaw' : '#91C8E4',
                'biruMiaw1' : '#749BC2',
                'biruMiaw2' : '#4682A9',
                'putihMiaw': '#F6F4EB',
                'hitamMiaw': '#241f42'
            }
        }
    }
}