<?php
require 'db.php'; // gives us $conn (mysqli)
date_default_timezone_set('Asia/Manila');

/* ================= SETTINGS (edit these) ================= */
$registeredVoters = 255; // total registered voters. Leave 0 to hide the turnout percentage.

// Optional per-position extras. Key must match the position name exactly.
$extras = [
    // 'Grade 7 Representative' => ['abstain' => 0, 'invalid' => 0],
];

$contactName  = 'SSLG Election Committee';
$contactEmail = 'sslg@example.com';
$contactNote  = 'Concerns or protests about the results must be filed with the committee.';
/* ========================================================== */

// Detect optional columns so the page works even if they don't exist yet
$cols = [];
if ($res = $conn->query("SHOW COLUMNS FROM candidates")) {
    while ($c = $res->fetch_assoc()) { $cols[strtolower($c['Field'])] = $c['Field']; }
}
$pick = function (array $options) use ($cols) {
    foreach ($options as $o) { if (isset($cols[$o])) return $cols[$o]; }
    return null;
};
$photoCol = $pick(['photo', 'image', 'picture', 'img']);
$partyCol = $pick(['party', 'partylist', 'section', 'team']);

$positions = [];
$result = $conn->query("SELECT * FROM candidates ORDER BY id ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pos = $row['position'] ?? 'Candidates';
        if (!isset($positions[$pos])) {
            $positions[$pos] = [
                'name'       => $pos,
                'abstain'    => (int) ($extras[$pos]['abstain'] ?? 0),
                'invalid'    => (int) ($extras[$pos]['invalid'] ?? 0),
                'candidates' => [],
            ];
        }
        $positions[$pos]['candidates'][] = [
            'name'  => $row['name'],
            'votes' => (int) $row['votes'],
            'photo' => $photoCol ? ($row[$photoCol] ?? '') : '',
            'party' => $partyCol ? ($row[$partyCol] ?? '') : '',
        ];
    }
}

$payload = [
    'positions'  => array_values($positions),
    'registered' => (int) $registeredVoters,
    'generated'  => date('M j, Y g:i:s A'),
];
$flags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSLG Election Results</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
    * {
        font-family: Poppins, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    :root {
        --blue-900: #0b3d91;
        --blue-700: #1f6feb;
        --blue-100: #eaf2ff;
        --yellow: #ffd449;
        --text: #0d1b2a;
        --muted: #6b7280;
        --white: #ffffff;
        --green: #15803d;
        --shadow: 0 10px 25px rgba(0,0,0,.08);
        --radius: 16px;
    }

    body { background: var(--blue-100); color: var(--text); }

    header {
        font-weight: bold;
        color: var(--white);
        height: 200px;
        background: linear-gradient(135deg, var(--blue-900), var(--blue-700));
    }

    .hero {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 15vh;
    }

    .hero p { letter-spacing: 2px; }

    .wrap { max-width: 1100px; margin: 0 auto; padding: 0 16px; }

    .panel {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 20px;
        min-width: 0;
    }

    .panel h2 { font-size: 1.05rem; margin-bottom: 14px; color: var(--blue-900); }

    /* Toolbar: tabs + actions */
    .toolbar {
        margin-top: -50px;
        display: flex;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        max-width: 100%;
        padding-bottom: 4px;
    }

    .tab {
        border: 0;
        cursor: pointer;
        padding: 9px 16px;
        border-radius: 999px;
        background: var(--white);
        color: var(--blue-900);
        font-weight: 600;
        font-size: .85rem;
        white-space: nowrap;
        box-shadow: var(--shadow);
    }

    .tab[aria-selected="true"] { background: var(--yellow); color: var(--text); }

    .actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

    .btn {
        border: 0;
        cursor: pointer;
        padding: 9px 14px;
        border-radius: 10px;
        background: var(--blue-900);
        color: var(--white);
        font-weight: 600;
        font-size: .8rem;
    }

    .btn.secondary { background: var(--white); color: var(--blue-900); box-shadow: var(--shadow); }

    .auto { font-size: .8rem; color: var(--text); display: flex; align-items: center; gap: 6px; background: var(--white); padding: 8px 12px; border-radius: 10px; box-shadow: var(--shadow); }

    .tab:focus-visible, .btn:focus-visible, input:focus-visible, th button:focus-visible {
        outline: 3px solid var(--yellow);
        outline-offset: 2px;
    }

    /* Winner banner */
    .banner {
        margin-top: 16px;
        padding: 16px 20px;
        border-radius: var(--radius);
        background: var(--white);
        box-shadow: var(--shadow);
        border-left: 8px solid var(--muted);
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .banner.won { border-left-color: var(--green); }
    .banner.tie { border-left-color: #f0b400; }
    .banner .title { font-weight: 700; font-size: 1.1rem; }
    .banner .sub { color: var(--muted); font-size: .85rem; }

    /* Stat cards */
    .stats {
        margin-top: 16px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat .label { font-size: .78rem; color: var(--muted); }
    .stat .value { font-size: 1.5rem; font-weight: 700; color: var(--blue-900); }
    .stat .note { font-size: .75rem; color: var(--muted); }

    .meter { height: 8px; border-radius: 99px; background: var(--blue-100); margin-top: 6px; overflow: hidden; }
    .meter div { height: 100%; background: var(--blue-700); }

    /* Results grid */
    .results {
        margin: 16px 0 24px;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    /* Bar chart */
    .chart { display: flex; height: 320px; }

    .y-axis {
        display: flex;
        flex-direction: column-reverse;
        justify-content: space-between;
        align-items: flex-end;
        padding-right: 8px;
        font-size: .75rem;
        color: var(--muted);
        width: 44px;
        margin-bottom: 40px;
    }

    .plot { flex: 1; display: flex; flex-direction: column; min-width: 0; }

    .bars {
        flex: 1;
        display: flex;
        align-items: flex-end;
        gap: 12px;
        border-left: 2px solid var(--muted);
        border-bottom: 2px solid var(--muted);
        padding: 0 12px;
        background: repeating-linear-gradient(
            to top, transparent 0, transparent calc(25% - 1px), #e5e7eb calc(25% - 1px), #e5e7eb 25%
        );
    }

    .bar-col {
        flex: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        min-width: 0;
    }

    .bar {
        width: 100%;
        max-width: 56px;
        background: linear-gradient(180deg, var(--blue-700), var(--blue-900));
        border-radius: 8px 8px 0 0;
        position: relative;
        transition: height .4s ease;
    }

    .bar.leader { background: linear-gradient(180deg, var(--yellow), #f0b400); }

    .bar span {
        position: absolute;
        top: -22px;
        left: 50%;
        transform: translateX(-50%);
        font-size: .75rem;
        font-weight: 600;
    }

    .labels { display: flex; gap: 12px; padding: 0 12px 0 14px; height: 40px; }

    .labels div {
        flex: 1;
        text-align: center;
        font-size: .72rem;
        padding-top: 6px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        min-width: 0;
    }

    /* Table */
    .search {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        margin-bottom: 10px;
        font-size: .85rem;
    }

    .table-wrap {
        max-height: 320px;
        overflow: auto;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    th, td { padding: 9px 10px; text-align: left; }

    th {
        position: sticky;
        top: 0;
        background: var(--blue-900);
        color: var(--white);
        font-weight: 600;
    }

    th button {
        all: unset;
        cursor: pointer;
        font-weight: 600;
        font-family: inherit;
    }

    th[aria-sort="ascending"] button::after { content: " ▲"; font-size: .65rem; }
    th[aria-sort="descending"] button::after { content: " ▼"; font-size: .65rem; }

    td.num, th.num { text-align: right; }
    tbody tr:nth-child(even) { background: var(--blue-100); }
    tbody tr.is-winner td:nth-child(2) { font-weight: 700; }

    .person { display: flex; align-items: center; gap: 8px; min-width: 0; }
    .person .who { min-width: 0; }
    .person .nm { display: block; }
    .person .pt { display: block; font-size: .7rem; color: var(--muted); }

    .avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--blue-700); color: var(--white);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .7rem; font-weight: 600; flex: none; object-fit: cover;
    }

    .badge {
        display: inline-block;
        font-size: .65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 99px;
        margin-left: 6px;
        vertical-align: middle;
    }

    .badge.elected { background: #dcfce7; color: var(--green); }
    .badge.tie { background: #fef3c7; color: #92400e; }

    .empty { padding: 20px; text-align: center; color: var(--muted); font-size: .85rem; }

    footer { background: var(--blue-900); color: var(--white); padding: 24px 0; font-size: .85rem; }
    footer .wrap { display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    footer a { color: var(--yellow); }
    .updated { font-size: .78rem; color: var(--muted); margin: 0 0 12px; }

    @media (max-width: 800px) {
        .results { grid-template-columns: 1fr; }
        .stats { grid-template-columns: repeat(2, 1fr); }
        .toolbar { margin-top: -30px; }
    }

    @media print {
        body { background: #fff; }
        header { height: auto; padding-bottom: 12px; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .toolbar .actions, .search, .tabs { display: none; }
        .toolbar { margin-top: 12px; }
        .panel, .banner { box-shadow: none; border: 1px solid #d1d5db; }
        .table-wrap { max-height: none; overflow: visible; }
        .bar, .badge, th, .meter div { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .results { grid-template-columns: 1fr 1fr; }
    }

    @media (prefers-reduced-motion: reduce) { .bar { transition: none; } }
    </style>
</head>

<body>
    <header>
        <div class="hero">
            <img src="sslg.png" alt="" width="50px">
            <p>SSLG Elections S.Y. 2026-2027</p>
        </div>
        <h1 align="center">RESULTS</h1>
    </header>

    <div class="wrap">
        <div class="toolbar">
            <div class="tabs" id="tabs" role="tablist" aria-label="Positions"></div>
            <div class="actions">
                <label class="auto"><input type="checkbox" id="autoRefresh"> Auto-refresh (30s)</label>
                <button class="btn secondary" id="csvBtn" type="button">Export CSV</button>
                <button class="btn" id="printBtn" type="button">Print / Save PDF</button>
            </div>
        </div>

        <div class="banner" id="banner"></div>

        <div class="stats" id="stats"></div>

        <main class="results">
            <section class="panel">
                <h2 id="chartTitle">Votes per candidate</h2>
                <div class="chart">
                    <div class="y-axis" id="yAxis"></div>
                    <div class="plot">
                        <div class="bars" id="bars"></div>
                        <div class="labels" id="labels"></div>
                    </div>
                </div>
            </section>

            <section class="panel">
                <h2>Vote count</h2>
                <input class="search" id="search" type="search" placeholder="Search candidate" aria-label="Search candidate">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th class="num" data-key="rank" aria-sort="ascending"><button type="button">#</button></th>
                                <th data-key="name"><button type="button">Candidate</button></th>
                                <th class="num" data-key="votes"><button type="button">Votes</button></th>
                                <th class="num" data-key="pct"><button type="button">%</button></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
                <div class="empty" id="noMatch" hidden>No candidates match your search.</div>
            </section>
        </main>

        <p class="updated">Last updated: <span id="updated"></span></p>
    </div>

    <footer>
        <div class="wrap">

        </div>
    </footer>

<script>
    const DATA = <?= json_encode($payload, $flags) ?>;

    // Add rank (ties share a rank), total and percent to every position
    DATA.positions.forEach(p => {
        p.total = p.candidates.reduce((s, c) => s + c.votes, 0);
        const sorted = [...p.candidates].sort((a, b) => b.votes - a.votes);
        p.candidates.forEach(c => {
            c.rank = sorted.findIndex(s => s.votes === c.votes) + 1;
            c.pct = p.total ? (c.votes / p.total) * 100 : 0;
        });
        p.max = Math.max(0, ...p.candidates.map(c => c.votes));
        p.leaders = p.max > 0 ? p.candidates.filter(c => c.votes === p.max) : [];
    });

    const $ = id => document.getElementById(id);
    let current = 0;
    let sortKey = "rank", sortDir = 1;

    function initials(name) {
        return name.split(/\s+/).filter(Boolean).slice(0, 2).map(w => w[0].toUpperCase()).join("");
    }

    function avatar(c) {
        if (c.photo) {
            const img = document.createElement("img");
            img.className = "avatar";
            img.src = c.photo;
            img.alt = "";
            img.onerror = () => img.replaceWith(initialsAvatar(c));
            return img;
        }
        return initialsAvatar(c);
    }

    function initialsAvatar(c) {
        const s = document.createElement("span");
        s.className = "avatar";
        s.textContent = initials(c.name);
        return s;
    }

    function renderTabs() {
        const tabs = $("tabs");
        tabs.innerHTML = "";
        DATA.positions.forEach((p, i) => {
            const b = document.createElement("button");
            b.className = "tab";
            b.type = "button";
            b.setAttribute("role", "tab");
            b.setAttribute("aria-selected", i === current);
            b.textContent = p.name;
            b.onclick = () => { current = i; history.replaceState(null, "", "#pos-" + i); render(); };
            tabs.appendChild(b);
        });
    }

    function renderBanner(p) {
        const b = $("banner");
        b.className = "banner";
        b.innerHTML = "";
        const t = document.createElement("div");
        const title = document.createElement("div");
        title.className = "title";
        const sub = document.createElement("div");
        sub.className = "sub";

        if (!p.leaders.length) {
            title.textContent = "No votes counted yet";
            sub.textContent = p.name;
        } else if (p.leaders.length === 1) {
            b.classList.add("won");
            title.textContent = "Elected: " + p.leaders[0].name;
            sub.textContent = p.name + " · " + p.max + " votes (" + p.leaders[0].pct.toFixed(1) + "%)";
        } else {
            b.classList.add("tie");
            title.textContent = "Tie: " + p.leaders.map(c => c.name).join(" and ");
            sub.textContent = p.name + " · " + p.max + " votes each. A tiebreaker is needed.";
        }
        t.append(title, sub);
        b.appendChild(t);
    }

    function stat(label, value, note, meterPct) {
        const d = document.createElement("div");
        d.className = "panel stat";
        d.innerHTML = '<div class="label"></div><div class="value"></div><div class="note"></div>';
        d.children[0].textContent = label;
        d.children[1].textContent = value;
        d.children[2].textContent = note || "";
        if (meterPct !== undefined) {
            const m = document.createElement("div");
            m.className = "meter";
            m.innerHTML = "<div></div>";
            m.firstChild.style.width = Math.min(100, meterPct) + "%";
            d.appendChild(m);
        }
        return d;
    }

    function renderStats(p) {
        const s = $("stats");
        s.innerHTML = "";
        const ballots = p.total + p.abstain + p.invalid;
        s.appendChild(stat("Valid votes", p.total, p.candidates.length + " candidates"));
        if (DATA.registered) {
            const pct = (ballots / DATA.registered) * 100;
            s.appendChild(stat("Turnout", pct.toFixed(1) + "%", "", pct));
        } else {
            s.appendChild(stat("Turnout", "N/A", "Set $registeredVoters in the PHP settings"));
        }
    }

    function renderChart(p) {
        $("chartTitle").textContent = p.name + ": votes per candidate";
        const bars = $("bars"), labels = $("labels"), yAxis = $("yAxis");
        bars.innerHTML = labels.innerHTML = yAxis.innerHTML = "";
        const yMax = Math.max(4, Math.ceil(p.max / 4) * 4);

        for (let i = 0; i <= 4; i++) {
            const tick = document.createElement("div");
            tick.textContent = Math.round((yMax / 4) * i);
            yAxis.appendChild(tick);
        }

        const list = [...p.candidates].sort((a, b) => b.votes - a.votes || a.name.localeCompare(b.name));
        list.forEach(c => {
            const col = document.createElement("div");
            col.className = "bar-col";
            const bar = document.createElement("div");
            bar.className = "bar" + (p.max > 0 && c.votes === p.max ? " leader" : "");
            bar.style.height = (c.votes / yMax) * 100 + "%";
            bar.title = c.name + ": " + c.votes + " votes (" + c.pct.toFixed(1) + "%)";
            const n = document.createElement("span");
            n.textContent = c.votes;
            bar.appendChild(n);
            col.appendChild(bar);
            bars.appendChild(col);

            const l = document.createElement("div");
            l.textContent = c.name;
            l.title = c.name;
            labels.appendChild(l);
        });
    }

    function renderTable(p) {
        const q = $("search").value.trim().toLowerCase();
        const rows = p.candidates
            .filter(c => c.name.toLowerCase().includes(q))
            .sort((a, b) => {
                const av = a[sortKey], bv = b[sortKey];
                const r = typeof av === "string" ? av.localeCompare(bv) : av - bv;
                const dir = (sortKey === "votes" || sortKey === "pct") ? -sortDir : sortDir;
                return r * dir || a.name.localeCompare(b.name);
            });

        const body = $("tableBody");
        body.innerHTML = "";
        rows.forEach(c => {
            const tr = document.createElement("tr");
            const isLeader = p.max > 0 && c.votes === p.max;
            if (isLeader) tr.className = "is-winner";

            const rank = document.createElement("td");
            rank.className = "num";
            rank.textContent = c.rank;

            const nameTd = document.createElement("td");
            const person = document.createElement("div");
            person.className = "person";
            const who = document.createElement("div");
            who.className = "who";
            const nm = document.createElement("span");
            nm.className = "nm";
            nm.textContent = c.name;
            if (isLeader) {
                const badge = document.createElement("span");
                badge.className = "badge " + (p.leaders.length > 1 ? "tie" : "elected");
                badge.textContent = p.leaders.length > 1 ? "Tie" : "Elected";
                nm.appendChild(badge);
            }
            who.appendChild(nm);
            if (c.party) {
                const pt = document.createElement("span");
                pt.className = "pt";
                pt.textContent = c.party;
                who.appendChild(pt);
            }
            person.append(avatar(c), who);
            nameTd.appendChild(person);

            const votes = document.createElement("td");
            votes.className = "num";
            votes.textContent = c.votes;

            const pct = document.createElement("td");
            pct.className = "num";
            pct.textContent = c.pct.toFixed(1) + "%";

            tr.append(rank, nameTd, votes, pct);
            body.appendChild(tr);
        });
        $("noMatch").hidden = rows.length > 0 || p.candidates.length === 0;
    }

    function render() {
        renderTabs();
        const p = DATA.positions[current];
        if (!p) {
            $("banner").textContent = "No candidates found in the database.";
            $("stats").innerHTML = "";
            return;
        }
        renderBanner(p);
        renderStats(p);
        renderChart(p);
        renderTable(p);
    }

    // Sorting: click a header. Rank/name ascend first, votes/% descend first.
    document.querySelectorAll("th[data-key]").forEach(th => {
        th.querySelector("button").onclick = () => {
            const key = th.dataset.key;
            if (sortKey === key) { sortDir *= -1; } else { sortKey = key; sortDir = 1; }
            document.querySelectorAll("th[data-key]").forEach(h => h.removeAttribute("aria-sort"));
            const natural = (key === "votes" || key === "pct") ? -sortDir : sortDir;
            th.setAttribute("aria-sort", natural === 1 ? "ascending" : "descending");
            renderTable(DATA.positions[current]);
        };
    });

    $("search").addEventListener("input", () => renderTable(DATA.positions[current]));

    // Export every position to CSV
    function csvCell(v) {
        let s = String(v);
        if (/^[=+\-@]/.test(s)) s = "'" + s; // block spreadsheet formula injection
        return '"' + s.replace(/"/g, '""') + '"';
    }

    $("csvBtn").onclick = () => {
        const lines = [["Position", "Candidate", "Votes", "Percent"].map(csvCell).join(",")];
        DATA.positions.forEach(p => p.candidates.forEach(c =>
            lines.push([p.name, c.name, c.votes, c.pct.toFixed(1) + "%"].map(csvCell).join(","))));
        const blob = new Blob(["\ufeff" + lines.join("\r\n")], { type: "text/csv;charset=utf-8" });
        const a = document.createElement("a");
        a.href = URL.createObjectURL(blob);
        a.download = "sslg-election-results.csv";
        a.click();
        URL.revokeObjectURL(a.href);
    };

    $("printBtn").onclick = () => window.print();

    // Auto-refresh every 30 seconds (remembers your choice)
    let timer = null;
    function setAuto(on) {
        clearInterval(timer);
        if (on) timer = setInterval(() => location.reload(), 30000);
        try { localStorage.setItem("sslgAutoRefresh", on ? "1" : "0"); } catch (e) {}
    }
    $("autoRefresh").onchange = e => setAuto(e.target.checked);
    try {
        if (localStorage.getItem("sslgAutoRefresh") === "1") { $("autoRefresh").checked = true; setAuto(true); }
    } catch (e) {}

    // Restore selected position after a refresh
    const m = location.hash.match(/^#pos-(\d+)$/);
    if (m && DATA.positions[+m[1]]) current = +m[1];

    $("updated").textContent = DATA.generated;
    render();
</script>
</body>
</html>
