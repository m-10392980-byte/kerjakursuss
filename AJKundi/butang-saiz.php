<head>
<link rel="stylesheet" href="css/style.css">
</head>

<script>
function ubahsaiz(gandaan) {
    var saiz = document.getElementById("saiz");
    saiz.style.fontSize = gandaan === 2 ? "1em" :
    (parseFloat(saiz.style.fontSize || 1) + (gandaan * 0.2)) + "em";
}
</script>

| ubah saiz tulisan |
<input style='font-size: 13px;padding: 5px 15px;background: darkblue;color: white;border: none;border-radius: 2px;cursor: pointer;' type='button' value='reset' onclick="ubahsaiz(2)" />
<input style='font-size: 13px;padding: 5px 15px;background: darkblue;color: white;border: none;border-radius: 2px;cursor: pointer;' type='button' value='&nbsp; + &nbsp;' onclick="ubahsaiz(+1)" />
<input style='font-size: 13px;padding: 5px 15px;background: darkblue;color: white;border: none;border-radius: 2px;cursor: pointer;' type='button' value='&nbsp; - &nbsp;' onclick="ubahsaiz(-1)" />

| <button style='font-size: 13px;padding: 5px 15px;background: darkblue;color: white;border: none;border-radius: 2px;cursor: pointer;' onclick="window.print()">Cetak</button>