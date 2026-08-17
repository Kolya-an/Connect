<!-- Cookie Banner -->
<div id="cookie-banner" class="cookie-banner" style="display: none;">
    <div class="cookie-content">
        <p>
            {{ __('Ми використовуємо cookie та подібні технології для покращення роботи сайту, аналітики та персоналізації.') }}
            <br>
            {{ __('Докладніше — у') }} <a href="/polozennia-pro-obrobku-personalnix-danix" target="_blank">{{ __('Політиці конфіденційності') }}</a>.
        </p>
        <div class="cookie-buttons">
            <button type="button" id="cookie-remind" class="btn-cookie btn-remind">
                {{ __('Нагадати пізніше') }}
            </button>
            <button type="button" id="cookie-accept" class="btn-cookie btn-accept">
                {{ __('Прийняти все') }}
            </button>
        </div>
    </div>
</div>

<style>
.cookie-banner {
    position: fixed;
    bottom: 20px;
    left: 20px;
    max-width: 440px;
    width: calc(100% - 40px);
    background-color: #121212;
    color: #ffffff;
    border-radius: 16px;
    padding: 18px 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    z-index: 999999;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.4;
}

.cookie-content p {
    margin: 0 0 16px 0;
    color: #e0e0e0;
}

.cookie-content a {
    color: #60a5fa;
    text-decoration: underline;
}

.cookie-content a:hover {
    color: #93c5fd;
}

.cookie-buttons {
    display: flex;
    gap: 10px;
}

.btn-cookie {
    flex: 1;
    padding: 12px 16px;
    border-radius: 12px;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

/* Кнопка "Нагадати пізніше" */
.btn-remind {
    background-color: #2a2a2a;
    color: #ffffff;
}

.btn-remind:hover {
    background-color: #383838;
}

/* Кнопка "Прийняти все" */
.btn-accept {
    background-color: #22c55e; /* зелений колір як на макеті */
    color: #ffffff;
}

.btn-accept:hover {
    background-color: #16a34a;
}

@media (max-width: 480px) {
    .cookie-banner {
        bottom: 10px;
        left: 10px;
        width: calc(100% - 20px);
    }
    .cookie-buttons {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById("cookie-banner");
    const btnAccept = document.getElementById("cookie-accept");
    const btnRemind = document.getElementById("cookie-remind");

    // Функція читання Cookie
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    // Функція запису Cookie
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
    }

    // Перевірка стану при завантаженні
    const cookieConsent = getCookie("cookie_consent");

    if (!cookieConsent) {
        banner.style.display = "block";
    }

    // Клік "Прийняти все" — зберігаємо на 1 рік (365 днів)
    btnAccept.addEventListener("click", function () {
        setCookie("cookie_consent", "accepted", 365);
        banner.style.display = "none";
    });

    // Клік "Нагадати пізніше" — приховуємо на 1 день (або сесію)
    btnRemind.addEventListener("click", function () {
        setCookie("cookie_consent", "remind", 1); // 1 день
        banner.style.display = "none";
    });
});
</script>