
            #FAF3E0
            #7A1F1F
            #D6EADF
            #b9e4ca  warna input
            #166534

#fff4d6
rgba(255,244,214,.6)
rgba(122,31,31,.35)

<form method='POST' action=''>
    <table style="position: relative; top: 80px;" class="table">
        <tr>
            <th class="daftar" style="font-size: 30px;">Daftar Pengguna Baru</th>
        </tr>
        <tr>
            <th class="daftar" style="font-size: 20px;">Sila Masukkan Maklumat Yang Diperlukan Di Bawah</th>
        </tr>
        <tr>
            <td><input class="" style="font-size: 17px;" type='text' name='noKP' placeholder="No Kad Pengenalan" required></td>   
        </tr>
        <tr>
            <td><input class="" style="font-size: 17px;" type='text' name='nama' placeholder="Nama" required></td>
        </tr>
        <tr>
            <td><input class="" style="font-size: 17px;" type='password' name='katalaluan' placeholder="Katalaluan" required></td>
        </tr>
        <tr>
            <td colspan='2' align='center'>
                <button style='font-size: 15px;padding: 12px 26px;background: darkblue;color: white;border: none;border-radius: 10px;cursor: pointer;' type='submit'>Daftar</button>
            </td>
        </tr>
    </table>
</form>
<?php include('footer.php'); ?>

.title{
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -1px;
    position: relative;
    display: flex;
    align-items: center;
    padding-left: 30px;
    color: #00bbff;
}
.title::before{
    width: 18px;
    height: 18px;
}
.title::after{
    width: 18px;
    height: 18px;
    animation: pulse 1s linear infinite;
}
.title::before,
.title::after{
    position: absolute;
    content: '';
    height: 16px;
    width: 16px;
    border-radius: 50%;
    left: 0px;
    background-color: #00bbff;
}
.message{
    font-size: 14.5px;
    color: rgba(255, 255, 255, 0.7);
}
.form label{
    position: relative;
}
.form label .input{
    background-color: #333;
    color: #fff;
    width: 100%;
    padding: 20px 05px 05px 10px;
    outline: 0;
    border: 1px solid rgba(105, 105, 105, 0.397);
    border-radius: 10px;
}
.form label .input + span{
    color: rgba(255, 255, 255,0.5);
    position: absolute;
    left: 10px;
    top: 0px;
    font-size: 0.9em;
    cursor: text;
    transition: 0.3s ease;
}
.form label .input:placeholder-shown + span {
    top: 12,5px;
    font-size: 0.9em;
}
.form label .input:focus + span,
.form label .input:valid + span{
    color: #00bbff;
    top: 0px;
    font-size: 0.7em;
    font-weight: 600;
}
