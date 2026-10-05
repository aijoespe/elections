<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8' />
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />
  <title>Thank You for Voting | SSLG Election 2026–2027</title>
  <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin />
  <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap' rel='stylesheet' />
  <style>
    :root{
      --blue-900:#0b3d91;
      --blue-700:#1f6feb;
      --blue-100:#eaf2ff;
      --yellow:#ffd449;
      --text:#0d1b2a;
      --muted:#6b7280;
      --white:#ffffff;
      --shadow:0 10px 25px rgba(0,0,0,.08);
      --radius:16px;
    }
    *{box-sizing:border-box}
    html,body{min-height:100%}
    body{
      margin:0;
      font-family:Poppins,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
      color:var(--text);
      background:
        radial-gradient(1200px 600px at -10% -10%, #e6f0ff 0%, transparent 60%),
        radial-gradient(900px 500px at 110% 10%, #e6f3ff 0%, transparent 60%),
        linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
        background-repeat: no-repeat;
      background-size: cover;
      background-attachment: fixed;
    }
    /* Decorative election SVGs behind the page content */
    body{isolation:isolate}
    body::before {
      content:'';
      position:fixed;
      inset:0;
      z-index:-1;
      pointer-events:none;
      background-image: url('data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='460' height='400' viewBox='0 0 460 400'%3E%3Cg fill='none' stroke='%231f6feb' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round' opacity='.13'%3E%3Cg transform='translate(34 50) rotate(-12 36 40)'%3E%3Cpath d='M12 34h48l12 18v34H0V52zM0 52h72M25 42h22'/%3E%3Cpath fill='%23eaf2ff' d='M22 2h28v32H22z'/%3E%3Cpath d='m28 17 6 6 10-12'/%3E%3C/g%3E%3Cg transform='translate(292 244) rotate(12 30 38)'%3E%3Crect width='60' height='76' rx='8'/%3E%3Cpath d='m12 21 5 5 8-10M34 22h14m-36 20 5 5 8-10M34 43h14M12 61h36'/%3E%3C/g%3E%3Cg transform='translate(330 56)'%3E%3Ccircle cx='25' cy='25' r='25'/%3E%3Cpath d='m12 25 9 9 18-19'/%3E%3C/g%3E%3C/g%3E%3Cg fill='none' stroke='%23ffd449' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' opacity='.28'%3E%3Cpath d='m132 252 7 15 17 2-12 12 3 17-15-8-15 8 3-17-12-12 17-2zM226 113v12m-6-6h12M415 346v12m-6-6h12'/%3E%3C/g%3E%3C/svg%3E');
      background-repeat: repeat;
      background-size: 460px 400px;
}

    @media (max-width:720px){
      body::before{background-size:340px 296px}
    }
    body{min-height:100vh;display:flex;flex-direction:column}
    .hero{
      padding:28px 20px 72px;
      text-align:center;
      color:var(--white);
      background:linear-gradient(135deg,var(--blue-900),var(--blue-700));
    }
    .brand{display:flex;align-items:center;justify-content:center;gap:12px;font-size:14px;font-weight:600}
    .brand-mark{width:40px;height:40px;flex-shrink:0;color:var(--yellow)}
    .hero p{font-size:12px;opacity:.8;margin:10px 0 0;letter-spacing:1px}
    main{width:100%;max-width:760px;margin:-40px auto 0;padding:0 20px;position:relative}
    .card{background:var(--white);border:1px solid #e9eef7;border-radius:24px;box-shadow:var(--shadow);overflow:hidden}
    .confirmation{text-align:center;padding:44px 40px 32px}
    .success-art{width:132px;height:112px;display:block;margin:0 auto 20px}
    .eyebrow{font-size:11px;font-weight:700;letter-spacing:1.8px;color:var(--blue-700);margin:0 0 10px;text-transform:uppercase}
    h1{font-size:clamp(27px,4vw,36px);line-height:1.25;letter-spacing:-.8px;color:#163969;margin:0 0 16px}
    .message{max-width:480px;margin:0 auto;color:#5f6b7a;font-size:14px;line-height:1.8}
    .message strong{font-weight:600;color:#183a63}
    .divider{display:flex;align-items:center;gap:14px;margin:28px 0 0;font-size:12px;color:#6b7280}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:#e8eef7}
    .next-voter{margin:0 24px 24px;padding:26px;border:1px solid #dce9fc;border-radius:16px;background:linear-gradient(135deg,#f7fbff,#eaf2ff)}
    .next-heading{display:flex;gap:12px;align-items:center;margin-bottom:10px}
    .next-icon{display:grid;place-items:center;width:38px;height:38px;flex-shrink:0;background:#fff;border:1px solid #dce9fc;border-radius:12px;color:var(--blue-700)}
    h2{font-size:18px;line-height:1.4;color:#163969;margin:0}
    .next-voter p{color:#5f6b7a;font-size:13px;line-height:1.8;margin:0 0 20px}
    .button{display:flex;align-items:center;justify-content:center;gap:12px;padding:15px 20px;min-height:52px;background:linear-gradient(135deg,#1f6feb,#2b85ff);border-radius:12px;color:#fff;text-decoration:none;font-size:14px;font-weight:700;box-shadow:0 8px 18px rgba(31,111,235,.18);transition:filter .2s}
    .button:hover{filter:brightness(1.07)}
    .button:focus-visible{outline:3px solid var(--blue-900);outline-offset:4px}
    .next-voter .helper{font-size:11px;text-align:center;margin:12px 0 0;color:#536781}
    .footer{text-align:center;font-size:11px;line-height:1.8;color:#5f6b7a;padding:22px 20px 28px}
    .footer strong{font-weight:600;color:#183a63}
    @media(max-width:540px){
      .hero{padding:24px 18px 64px}
      .brand{font-size:12px;gap:8px}
      main{padding:0 14px}
      .confirmation{padding:32px 22px 24px}
      .next-voter{margin:0 14px 14px;padding:20px}
      .success-art{width:112px;height:96px}
      h2{font-size:16px}
    }
  </style>
</head>
<body>
  <!-- Show this page only after testingvote.php successfully saves the ballot. -->
  <header class='hero'>
    <div class='brand'>
      <svg class='brand-mark' viewBox='0 0 40 40' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' aria-hidden='true' focusable='false'>
        <path d='M7 19h26l4 7v10H3V26zM3 26h34M15 22h10' />
        <path d='M13 3h14v16H13zM17 10l3 3 4-5' />
      </svg>
      <span>SSLG Elections School Year 2026–2027</span>
    </div>
    <p>YOUR VOTE. YOUR VOICE.</p>
  </header>

  <main>
    <section class='card' aria-labelledby='thank-you-title'>
      <div class='confirmation'>
        <svg class='success-art' viewBox='0 0 132 112' fill='none' aria-hidden='true' focusable='false'>
          <circle cx='66' cy='56' r='47' fill='#eaf2ff' />
          <path d='M9 27v10M4 32h10M119 76v8M115 80h8' stroke='#ffd449' stroke-width='3' stroke-linecap='round' />
          <path d='m114 18 2 5 5 1-4 4 1 5-4-3-5 3 1-5-4-4 6-1z' fill='#ffd449' />
          <path d='M35 52h55l9 15v28H26V67z' fill='#fff' stroke='#1f6feb' stroke-width='2.5' stroke-linejoin='round' />
          <path d='M26 67h73M52 60h22' stroke='#1f6feb' stroke-width='2.5' stroke-linecap='round' />
          <rect x='48' y='18' width='33' height='35' rx='4' fill='#fff' stroke='#1f6feb' stroke-width='2.5' transform='rotate(-8 64 35)' />
          <path d='m56 34 6 5 10-12' stroke='#1f6feb' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' />
          <circle cx='91' cy='86' r='16' fill='#0b3d91' stroke='#fff' stroke-width='3' />
          <path d='m84 86 5 5 9-10' stroke='#ffd449' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round' />
        </svg>
        <p class='eyebrow'>Voting complete</p>
        <h1 id='thank-you-title'>Thank you for voting!</h1>
        <p class='message'><strong>Your voice helps shape our school.</strong><br>You're all done. Please make room for the next voter and leave this page open on the laptop.</p>
        <div class='divider'>Let's welcome the next voice</div>
      </div>

      <section class='next-voter' aria-labelledby='next-voter-title'>
        <div class='next-heading'>
          <span class='next-icon' aria-hidden='true'>
            <svg width='22' height='22' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' focusable='false'>
              <circle cx='9' cy='7' r='3' /><path d='M3 20v-2a6 6 0 0 1 12 0v2M17 10l4 4-4 4M15 14h6' />
            </svg>
          </span>
          <h2 id='next-voter-title'>Next voter, you're up!</h2>
        </div>
        <p>Ready to make your choice? Start a fresh ballot, enter your own information, and select your candidates.</p>
        <a class='button' href='index.php'>
          Next voter · Start voting
          <svg width='19' height='19' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' aria-hidden='true' focusable='false'><path d='M5 12h14m-6-6 6 6-6 6' /></svg>
        </a>
        <p class='helper'>Opens a blank form for the next voter.</p>
      </section>
    </section>
  </main>

  <footer class='footer'><strong>Every voice matters.</strong><br>Made by PCSHS ANJA</footer>
</body>
</html>