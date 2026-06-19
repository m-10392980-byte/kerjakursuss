<?php
session_start();
include("header.php");
?>

<style>

    .h1 {
        color: white;
        text-shadow: 2px 2px 4px #000000;
        width: min(250px, 92vw);
        margin: 10px auto;
        padding: 10px;
        background: darkblue;   
        border: 3px solid #001a7a;            
        border-radius: 18px;
        box-shadow: 0 10px 22px rgba(0,0,0,.18);
        text-align: center;
    }

    .peng {
        position: relative;
        top: 50px;
        width: min(900px, 92vw);
        margin: 10px auto;
        padding: 10px;
        background: lightblue;   
        border: 3px solid #001a7a;            
        border-radius: 18px;
        box-shadow: 0 10px 22px rgba(0,0,0,.18);
        text-align: center;
    }

    .peng h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .jawatan {
        color: #e63946;
        font-weight: bold;
    }
</style>

<div class="peng">
    <h1 class="h1">[PENGENALAN]</h1>
    <h2>Ini Adalah Website Pengundian Pemilihan AJK Kadet Polis.</h2>
    <h2>Terdapat Empat Kategori Jawatan Yang Akan Dipertandingkan. Iaitu</h2>
    <h2 class="jawatan">Pengerusi, Timbalan Pengerusi, Setiausaha dan Bendahari.</h2>
    <h2>Melalui sistem pengundian ini, setiap penduduk berpeluang memilih wakil mereka secara telus dan adil, memastikan vote setiap individu diambil kira dalam proses pemilihan.</h2>
    <h2>Kami menggalakkan semua penduduk untuk terlibat dalam pengundian ini demi masa depan kampung yang lebih baik.</h2>
    <h2>Selamat mengundi!</h2>
</div>

<?php include("footer.php"); ?>