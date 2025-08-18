<style>
    footer {
    background-color: #333;
    color: white;
    padding: 20px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
}

.footer .logo-instansi {
    width: 100px;
    height: 100px;
    margin-right: 5px;
}

.footer .alamat {
    margin: 0 10px;
    flex-grow: 1;
}

.footer .alamat p {
    margin: 5px 0;
}

.footer .tautan {
    margin: 0 10px;
}

.footer .tautan p {
    margin: 5px 0;
}

.footer .tautan a {
    color: white;
    text-decoration: none;
}

.footer .sosmed {
    margin: 0 20px;
    text-align: center;
}

.footer .sosmed p {
    margin-bottom: 10px;
}

.footer .logo-sosmed {
    width: 30px;
    height: 30px;
    margin: 0 5px;
}
.footer .whatsapp-logo {
    width: 16px;
    height: 16px;
}
.footer .alamat img {
    width: 20px;
    height: 20px;
    margin-right: 5px;
}
@media (max-width: 768px){
footer-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer .logo-instansi {
        margin-bottom: 10px;
    }

    .footer .alamat,
    .footer .tautan,
    .footer .sosmed {
        margin: 5px;
    }
    .footer .alamat img {
        display: inline-block;
        margin-bottom: 5px;
    }
    .footer .alamat p {
        margin: 5px 0;
    }
}
</style>
<footer class="footer">
    <div class="footer-content">
        <img src="{{ asset('/images/footer/logoPetungPark.png') }}" alt="Logo Instansi" class="logo-instansi">
        <div class="alamat">
            <p><b>Alamat</b></p>
            <p>{{ $footerInfo['alamat'] }}</p>
            <div class="d-flex align-items-center">
                <img src="{{ asset($footerInfo['whatsapp_logo']) }}" alt="Logo WA" class="whatsapp-logo">
                <p>{{ $footerInfo['whatsapp'] }}</p>
            </div>
        </div>
        <div class="tautan">
            <p><b>Tautan</b></p>
            <a href="{{ asset($footerInfo['websiteDesa']) }}"><u>Desa Belik</u></a>
        </div>
        <div class="sosmed">
            <p><b>Sosial Media</b></p>
            <a href="{{ asset($footerInfo['instagram']) }}">
                <img src="{{ asset($footerInfo['instagram_logo']) }}" alt="Instagram" class="logo-sosmed">
            </a>
            <a href="{{ asset($footerInfo['tiktok']) }}">
                <img src="{{ asset($footerInfo['tiktok_logo']) }}" alt="TikTok" class="logo-sosmed">
            </a>
            <a href="{{ asset($footerInfo['youtube']) }}">
                <img src="{{ asset($footerInfo['youtube_logo']) }}" alt="Youtube" class="logo-sosmed">
            </a>
        </div>
    </div>
</footer>

