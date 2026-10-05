<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SSLG Elections 2026–2027</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
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
    body::before{
      content:"";
      position:fixed;
      inset:0;
      z-index:-1;
      pointer-events:none;
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='460' height='400' viewBox='0 0 460 400'%3E%3Cg fill='none' stroke='%231f6feb' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round' opacity='.13'%3E%3Cg transform='translate(34 50) rotate(-12 36 40)'%3E%3Cpath d='M12 34h48l12 18v34H0V52zM0 52h72M25 42h22'/%3E%3Cpath fill='%23eaf2ff' d='M22 2h28v32H22z'/%3E%3Cpath d='m28 17 6 6 10-12'/%3E%3C/g%3E%3Cg transform='translate(292 244) rotate(12 30 38)'%3E%3Crect width='60' height='76' rx='8'/%3E%3Cpath d='m12 21 5 5 8-10M34 22h14m-36 20 5 5 8-10M34 43h14M12 61h36'/%3E%3C/g%3E%3Cg transform='translate(330 56)'%3E%3Ccircle cx='25' cy='25' r='25'/%3E%3Cpath d='m12 25 9 9 18-19'/%3E%3C/g%3E%3C/g%3E%3Cg fill='none' stroke='%23ffd449' stroke-width='3' stroke-linecap='round' stroke-linejoin='round' opacity='.28'%3E%3Cpath d='m132 252 7 15 17 2-12 12 3 17-15-8-15 8 3-17-12-12 17-2zM226 113v12m-6-6h12M415 346v12m-6-6h12'/%3E%3C/g%3E%3C/svg%3E");
      background-repeat:repeat;
      background-size:460px 400px;
    }
    @media (max-width:720px){
      body::before{background-size:340px 296px}
    }
    /* Header */
    .hero{
      position:relative;
      padding:48px 20px 24px;
      text-align:center;
      color:var(--white);
      background:linear-gradient(135deg, var(--blue-900), var(--blue-700));
      overflow:hidden;
    }
    .hero:after{
      content:"";
      position:absolute;
      inset:auto -10% -80px -10%;
      height:160px;
      background:radial-gradient(120px 60px at 10% 0, rgba(255,255,255,.35), transparent 60%),
                 radial-gradient(200px 90px at 90% 0, rgba(255,255,255,.25), transparent 60%);
      filter:blur(10px);
      pointer-events:none;
    }

    .badge-dot{
      width:8px;height:8px;border-radius:50%;
      background:var(--yellow);
      box-shadow:0 0 0 4px rgba(255,212,73,.25);
    }
    .title{
      margin:14px auto 6px;
      font-size:clamp(26px, 4vw, 40px);
      font-weight:800;
      letter-spacing:.2px;
    }
    .subtitle{
      margin:0 auto 18px;
      font-size:14px;
      opacity:.9;
      max-width:800px;
    }

    /* Container */
    .container{
      max-width:980px;
      margin:-40px auto 40px;
      padding:0 16px;
    }



    /* Card/Form */
    .card{
      background:var(--white);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      overflow:hidden;
      border:1px solid #e9eef7;
      animation:floatIn .6s ease both;
    }
    @keyframes floatIn{
      from{opacity:0;transform:translateY(10px)}
      to{opacity:1;transform:translateY(0)}
    }
    .card-header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      padding:18px 22px;
      background:linear-gradient(180deg, #f7fbff, #ffffff);
      border-bottom:1px solid #eaf2ff;
    }
    .card-header h2{
      margin:0;font-size:18px;font-weight:700;color:#163969
    }
    .tip{
      font-size:13px;color:var(--muted)
    }
    .form{
      padding:22px;
      display:grid;
      grid-template-columns:1fr;
      gap:18px;
    }
    .grid-2{display:grid; grid-template-columns:1fr 1fr; gap:14px}
    @media (max-width:720px){
      .grid-2{grid-template-columns:1fr}
    }
    label{
      display:block;
      font-size:13px;
      font-weight:600;
      color:#1e3a5f;
      margin-bottom:6px;
    }
    input[type="text"], select{
      width:100%;
      padding:12px 14px;
      border:1px solid #d8e3f5;
      border-radius:12px;
      background:#fbfdff;
      color:#0d1b2a;
      outline:none;
      transition:.2s border,.2s box-shadow,.2s background;
      appearance:none;
    }
    input[type="text"]:focus, select:focus{
      border-color:#9cc2ff;
      box-shadow:0 0 0 4px rgba(31,111,235,.12);
      background:#ffffff;
    }
    .role{
      padding:14px;
      border:1px solid #e8f0ff;
      border-radius:14px;
      background:linear-gradient(180deg,#fcfeff,#f6faff);
    }
    .role-title{
      display:flex;align-items:center;gap:10px;
      font-weight:700;color:#183a63;margin-bottom:8px;
    }
    .role-badge{
      padding:2px 8px;font-size:11px;border-radius:999px;
      background:#e8f2ff;color:#2a5fb9;border:1px solid #cfe0ff
    }
    .note{
      font-size:12px;color:#6b7280;margin-top:4px
    }

    /* Footer actions */
    .actions{
      display:flex;align-items:center;justify-content:space-between;
      gap:12px;margin-top:6px
    }
    .btn{
      display:inline-flex;align-items:center;justify-content:center;
      gap:8px;
      padding:12px 18px;border-radius:12px;border:0;cursor:pointer;
      font-weight:700;letter-spacing:.2px;transition:transform .06s ease, filter .2s ease, box-shadow .2s ease;
    }
    .btn:active{transform:translateY(1px)}
    .btn-primary{
      background:linear-gradient(135deg, #1f6feb, #2b85ff);
      color:#fff;
      box-shadow:0 10px 18px rgba(31,111,235,.25);
    }
    .btn-primary:hover{filter:brightness(1.03)}
    .btn-ghost{
      background:#fff;color:#1f6feb;border:1px solid #bfd7ff;
    }

    /* Footer */
    .site-footer{
      text-align:center;
      color:#5f6b7a;
      font-size:12px;
      padding:16px 12px 32px;
    }

    .brand {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #fff;
      font-weight: 700;
      letter-spacing: 3px;
    }
    .logo {
      width: 50px;
      height: 50px;
      background-image: url(sslg.png);
      background-size: cover;
    }

    select {
      background-image: linear-gradient(45deg, transparent 50%, #2a5fb9 50%), linear-gradient(135deg, #2a5fb9 50%, transparent 50%), linear-gradient(to right, #cfe0ff, #cfe0ff);
      background-position: calc(100% - 18px) calc(1em - 2px), calc(100% - 13px) calc(1em - 2px), calc(100% - 2.5rem) .8em;
      background-size: 6px 6px, 6px 6px, 1px 1.4em;
      background-repeat: no-repeat;
    }

    .helper {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin: 8px 0 0
    }
    .chip {
      font-size: 11px;
      color: #2a5fb9;
      background: #eaf2ff;
      border: 1px solid #cfe0ff;
      border-radius: 999px;
      padding: 4px 8px
    }
  </style>
</head>
<body>

  <header class="hero">
    <div class="brand">
      <div class="logo" aria-hidden="true"></div>
      <div>SSLG Elections School Year 2026-2027 </div>
    </div>

    <h1 class="title">Your Vote. Your Voice.</h1>
    <p class="subtitle">Please complete your information and select ONE candidate only per position. You may choose Abstain.</p>
  </header>

  <main class="container">
    <section class="card">
      <div class="card-header">
        <h2>Voter Information</h2>
        <div class="tip">All fields are required</div>
      </div>

      <form class="form" action="insert.php" method="POST">
        <div class="grid-2">
          <div>
            <label for="fullname">Last Name</label>
            <input id="fullname" type="text" placeholder="ex. DELA CRUZ" name="ln" required />
          </div>
          <div>
            <label for="fullname">First Name</label>
            <input id="fullname" type="text" placeholder="ex. Juan Miguel" name="fn" required />
          </div>
          <div>
            <label for="fullname">Middle Name</label>
            <input id="fullname" type="text" placeholder="ex. Pimentel" name="mn" required />
          </div>
          <div>
            <label for="lrn">Learner Reference Number</label>                  
            <input id="lrn" type="text" inputmode="numeric" min="12" max="12" placeholder="Ex. 409914378245" name="LRN" required />
            <div class="note">seen on your ID</div>
          </div>
        </div>
        <div>
          <label for="section">Choose your section</label>
          <select name="Section" id="section" required>
            <option value="archimedes">7 - Archimedes</option>
            <option value="aristotle">7 - Aristotle</option>
            <option value="curie">7 - Curie</option>
            <option value="darwin">7 - Darwin</option>
            <option value="edison">7 - Edison</option>
            <option value="einstein">7 - Einstein</option>
            <option value="galileo">7 - Galileo</option>
          </select>
        </div>

        <div class="card-header" style="margin-top:6px">
          <h2>Ballot</h2>
          <div class="tip">Select your candidate for each position</div>
        </div>

        <!-- Roles grid -->
        <div class="grid-2">
    <div class="role">
      <div class="role-title">Grade 7 Representative No.1 <span class="role-badge">Vote 1</span></div>
        <label for="g7rep1">Choose candidate</label>
        <select name="g7rep1" id="g7rep1" required>
          <option value="">-- Select Candidate --</option>
          <option value="Abstain">Abstain</option>
          <option value="1">Purple Cheese B. Hiyao</option>
          <option value="2">Jetrix A. Nieves</option>
          <option value="3">Janna Mika C. Agustin</option>
          <option value="4">Morris Joshua Sunga</option>
          <option value="5">Britanny Faith N. Ungco</option>
          <option value="6">Adelaide Marguerite M. Vivar</option>
        </select>
    </div>
    <div class="role">
        <div class="role-title">Grade 7 Representative No.2 <span class="role-badge">Vote 1</span></div>
        <label for="g7rep2">Choose candidate</label>
        <select name="g7rep2" id="g7rep2" required>
            <option value="">-- Select Candidate --</option>
            <option value="Abstain">Abstain</option>
            <option value="1">Purple Cheese B. Hiyao</option>
            <option value="2">Jetrix A. Nieves</option>
            <option value="3">Janna Mika C. Agustin</option>
            <option value="4">Morris Joshua Sunga</option>
            <option value="5">Britanny Faith N. Ungco</option>
            <option value="6">Adelaide Marguerite M. Vivar</option>
        </select>
        </div>
    </div>
          <div class="actions">
          <button type="reset" class="btn btn-ghost">Clear Form</button>
          <button id="knee" type="submit" class="btn btn-primary">Submit Ballot</button>
        </div>
      </form>
    </section>

    <footer class="site-footer">
      Please review all of your options before selecting
    </footer>
  </main>
 <script>
const selects = document.querySelectorAll(
    '#g7rep1, #g7rep2'
);

// Store original options
const originalOptions = {};
selects.forEach(select => {
    originalOptions[select.id] = Array.from(select.options).map(opt => ({
        value: opt.value,
        text: opt.text
    }));
});

function updateDropdowns() {

    // Get all selected values except Abstain
    const selectedValues = Array.from(selects)
        .map(select => select.value)
        .filter(value => value !== "Abstain" && value !== "");

    selects.forEach(currentSelect => {

        const currentValue = currentSelect.value;

        // Clear existing options
        currentSelect.innerHTML = "";

        // Rebuild options
        originalOptions[currentSelect.id].forEach(option => {

            // Always allow Abstain and the currently selected value
            if (
                option.value === "Abstain" ||
                option.value === currentValue ||
                !selectedValues.includes(option.value)
            ) {
                const opt = document.createElement("option");
                opt.value = option.value;
                opt.textContent = option.text;

                if (option.value === currentValue) {
                    opt.selected = true;
                }

                currentSelect.appendChild(opt);
            }
        });
    });
}

// Run whenever a selection changes
selects.forEach(select => {
    select.addEventListener("change", updateDropdowns);
});

// Initial load
updateDropdowns();
</script>
</body>
</html>