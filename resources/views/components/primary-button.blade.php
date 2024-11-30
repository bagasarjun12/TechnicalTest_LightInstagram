<style>
    .bg-gradient-red-blue {
        background: linear-gradient(45deg, red, blue); /* Gradient miring 45 derajat */
        border: none; /* Menghapus border */
        border-radius: 0.375rem; /* Sudut membulat */
        color: white; /* Warna teks */
        font-weight: 600; /* Ketebalan font */
        font-size: 0.75rem; /* Ukuran font */
        text-transform: uppercase; /* Teks menjadi huruf kapital */
        letter-spacing: 0.05em; /* Jarak antar huruf */
        padding: 0.5rem 1rem; /* Padding */
        transition: background 0.3s ease-in-out; /* Efek transisi */
    }

    .bg-gradient-red-blue:hover {
        opacity: 0.8; /* Efek hover */
    }

    .bg-gradient-red-blue:focus {
        outline: none; /* Menghapus outline */
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5); /* Bayangan fokus */
    }
</style>
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center bg-gradient-red-blue']) }}>
    {{ $slot }}
</button>
