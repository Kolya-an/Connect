<!DOCTYPE html>
<html lang="uk">
<head>
<meta charset="UTF-8">
<meta name="robots" content="noindex, nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Реєстрація учасників навчання</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --teal:#0EA5A0;
  --teal-dark:#0B7A76;
  --teal-mid:#5CC8C4;
  --teal-light:#E0F7F6;
  --teal-bg:#F0FAFA;
  --teal-border:#A8E0DE;
  --text:#1A3A3A;
  --muted:#4A7A78;
  --border:#C8E8E7;
  --white:#fff;
  --radius:10px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--teal-bg);color:var(--text);min-height:100vh;padding:2rem 1rem}
.page{max-width:680px;margin:0 auto}

.header{text-align:center;margin-bottom:2rem}
.logo{display:inline-block;background:var(--teal);color:#fff;font-size:12px;font-weight:700;letter-spacing:.14em;padding:5px 16px;border-radius:20px;margin-bottom:1rem;text-transform:uppercase}
h1{font-size:26px;font-weight:700;color:var(--teal-dark);line-height:1.25;margin-bottom:.4rem}
.subtitle{font-size:14px;color:var(--muted)}

.card{background:#fff;border:1px solid var(--teal-border);border-radius:14px;padding:1.5rem;margin-bottom:1rem}
.card-title{font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--teal);margin-bottom:1.1rem;display:flex;align-items:center;gap:7px}
.card-title::before{content:'';display:block;width:3px;height:14px;background:var(--teal);border-radius:2px;flex-shrink:0}

.grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
@media(max-width:500px){.grid2{grid-template-columns:1fr}}
.field{display:flex;flex-direction:column;gap:5px}
label{font-size:13px;font-weight:600;color:var(--muted)}
input,select{
  width:100%;padding:9px 12px;
  border:1px solid var(--border);
  border-radius:var(--radius);
  font-size:14px;color:var(--text);
  background:#fff;font-family:inherit;
  outline:none;transition:border-color .15s,box-shadow .15s;
}
input:focus,select:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(14,165,160,.1)}
select{cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%230EA5A0' stroke-width='1.8' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:32px}

.participant-card{background:var(--teal-bg);border:1px solid var(--teal-border);border-radius:10px;padding:1rem;margin-bottom:.75rem}
.p-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem}
.p-num{font-size:12px;font-weight:700;color:var(--teal-dark);background:var(--teal-light);padding:3px 10px;border-radius:20px;border:1px solid var(--teal-border)}
.remove-btn{background:none;border:none;cursor:pointer;color:#aaa;font-size:18px;padding:2px 6px;border-radius:4px;transition:color .15s,background .15s}
.remove-btn:hover{color:#c0392b;background:#fdecea}

.add-btn{display:flex;align-items:center;gap:7px;padding:9px 16px;border:1.5px dashed var(--teal-mid);border-radius:var(--radius);background:transparent;color:var(--teal);font-size:14px;font-weight:600;cursor:pointer;width:100%;justify-content:center;transition:all .15s}
.add-btn:hover{background:var(--teal);border-color:var(--teal);color:#fff}
.counter{font-size:12px;color:var(--muted);text-align:right;margin-top:.5rem}

.submit-btn{width:100%;padding:13px;border:none;border-radius:var(--radius);background:var(--teal);color:#fff;font-size:16px;font-weight:700;cursor:pointer;transition:background .15s;margin-top:.5rem;letter-spacing:.02em}
.submit-btn:hover{background:var(--teal-dark)}
.submit-btn:active{transform:scale(.99)}
.submit-btn:disabled{background:var(--teal-mid);cursor:not-allowed}

.success{display:none;background:var(--teal-light);border:1px solid var(--teal-mid);border-radius:12px;padding:1.5rem;text-align:center;margin-top:1rem}
.success h3{color:var(--teal-dark);font-size:17px;margin-bottom:.3rem}
.success p{color:var(--teal);font-size:14px}

.error-box{display:none;background:#fdecea;border:1px solid #f5a5a3;border-radius:12px;padding:1rem 1.25rem;margin-top:1rem;font-size:14px;color:#c0392b}

.tools-row{display:flex;gap:.5rem;margin-top:.75rem;flex-wrap:wrap}
.tool-btn{flex:1;min-width:140px;display:flex;align-items:center;gap:6px;padding:8px 14px;border:1px solid var(--teal-border);border-radius:var(--radius);background:#fff;color:var(--muted);font-size:13px;cursor:pointer;justify-content:center;transition:all .15s}
.tool-btn:hover{border-color:var(--teal);color:var(--teal)}

.required{color:var(--teal);margin-left:2px}
</style>
</head>
<body>
<div class="page">
  <div class="header">
    <div class="logo">Реєстрація навчань</div>
    <h1>Анкета учасників навчання</h1>
    <p class="subtitle">Заповніть після кожного проведеного навчання</p>
  </div>

  <div class="card">
    <div class="card-title">Основна інформація</div>
    <div class="grid2">
      <div class="field">
        <label>Дата навчання <span class="required">*</span></label>
        <input type="date" id="date">
      </div>
      <div class="field">
        <label>Місто <span class="required">*</span></label>
        <input type="text" id="city" placeholder="Наприклад: Київ">
      </div>
      <div class="field">
        <label>Спікер / тренер <span class="required">*</span></label>
        <select id="speaker">
          <option value="">— оберіть тренера —</option>
          <option>Тумар Ольга</option>
          <option>Глазепа Антоніна</option>
          <option>Бойко Галина</option>
          <option>Пашковська Оксана</option>
          <option>Косова Валерія</option>
          <option>Макіша Наталія</option>
          <option>Панчук Марія</option>
          <option>Качук Юлія</option>
          <option>Коркунда Світлана</option>
          <option>Сідько Інна</option>
          <option>Зіменковський Андрій</option>
          <option>Савва Магдебура</option>
          <option>Барандій Юлія</option>
          <option>Гара Алла</option>
          <option>Ромащенко Наталія</option>
          <option>Харшман Віра</option>
          <option>Качук / Підмурняк</option>
          <option>Гогоша Софія</option>
          <option>Карпінський Олександр</option>
          <option>Череповська Олена</option>
          <option>Бесараб Маріанна</option>
          <option>Петраш Андрій</option>
          <option>Лебедев Денис</option>
          <option>Куляс Вікторія</option>
          <option>Сташенко Олександра</option>
          <option>Сосна Вікторія</option>
        </select>
      </div>
      <div class="field">
        <label>Бренд навчання <span class="required">*</span></label>
        <select id="brand">
          <option value="">— оберіть бренд —</option>
          <option>Alexa</option>
          <option>Algeness</option>
          <option>Hyalual</option>
          <option>Electri</option>
          <option>Perfoskin</option>
        </select>
      </div>
    </div>
    <div class="field" style="margin-top:12px">
      <label>Тема навчання <span class="required">*</span></label>
      <input type="text" id="topic" placeholder="Введіть тему навчання">
    </div>
    <div class="field" style="margin-top:12px">
      <label>Інше</label>
      <input type="text" id="other" placeholder="Додаткова інформація (необов'язково)">
    </div>
  </div>

  <div class="card">
    <div class="card-title">Учасники навчання</div>
    <div id="participants-list"></div>
    <button class="add-btn" onclick="addP()">+ Додати учасника</button>
    <div class="counter" id="counter">Учасників: 0</div>
  </div>

  <button class="submit-btn" id="submit-btn" onclick="submitForm()">Зберегти анкету</button>

  <div class="success" id="success">
    <div style="font-size:36px;margin-bottom:.4rem">✅</div>
    <h3 id="success-title">Анкету збережено!</h3>
    <p id="success-msg"></p>
  </div>
  <div class="error-box" id="error-box"></div>

  <div class="tools-row">
    <button class="tool-btn" onclick="exportExcel()">⬇ Завантажити Excel</button>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
/* ==========================================================
   ВАЖЛИВО: вставте сюди URL вашого Google Apps Script
   (отримаєте його після деплою скрипта в Google Таблиці —
   інструкція надана окремо)
   ========================================================== */
const SHEET_URL = 'https://script.google.com/macros/s/AKfycbxrctL-WO1-tZU8jGfRjfmvuLlI9TYOxNGxvbFGxPBumjM8gIj3Ts4BSveiV3xptuWs/exec';

const LSKEY = 'training_v2';
let pCount = 0;

function getData(){try{return JSON.parse(localStorage.getItem(LSKEY)||'[]')}catch(e){return[]}}
function saveData(a){localStorage.setItem(LSKEY,JSON.stringify(a))}

function addP(){
  pCount++;
  const list=document.getElementById('participants-list');
  const div=document.createElement('div');
  div.className='participant-card';
  div.id='p'+pCount;
  const n=pCount;
  div.innerHTML=`
    <div class="p-header">
      <span class="p-num" id="pn${n}">Учасник ${n}</span>
      <button class="remove-btn" onclick="removeP('p${n}')" title="Видалити">✕</button>
    </div>
    <div class="grid2">
      <div class="field">
        <label>Прізвище та ім'я</label>
        <input type="text" placeholder="Іваненко Олена" data-f="name">
      </div>
      <div class="field">
        <label>Телефон</label>
        <input type="tel" placeholder="+380XXXXXXXXX" data-f="phone">
      </div>
      <div class="field" style="grid-column:1/-1">
        <label>Місто</label>
        <input type="text" placeholder="Київ" data-f="city">
      </div>
    </div>`;
  list.appendChild(div);
  updCounter();
  div.querySelector('[data-f="name"]').focus();
}

function removeP(id){
  const el=document.getElementById(id);
  if(el)el.remove();
  updCounter();
}

function updCounter(){
  const cards=document.querySelectorAll('.participant-card');
  document.getElementById('counter').textContent='Учасників: '+cards.length;
  cards.forEach((c,i)=>{
    const b=c.querySelector('.p-num');
    if(b)b.textContent='Учасник '+(i+1);
  });
}

function formatDate(d){
  if(!d)return'';
  const[y,m,day]=d.split('-');
  return`${day}.${m}.${y}`;
}

async function submitForm(){
  const date=document.getElementById('date').value;
  const city=document.getElementById('city').value.trim();
  const speaker=document.getElementById('speaker').value;
  const brand=document.getElementById('brand').value;
  const topic=document.getElementById('topic').value.trim();
  const other=document.getElementById('other').value.trim();

  if(!date||!city||!speaker||!brand||!topic){
    showError('Заповніть усі обов\'язкові поля (*)');return;
  }

  const participants=[];
  document.querySelectorAll('.participant-card').forEach(card=>{
    const p={};
    card.querySelectorAll('[data-f]').forEach(i=>p[i.dataset.f]=i.value.trim());
    if(p.name)participants.push(p);
  });
  if(!participants.length){showError('Додайте хоча б одного учасника');return;}

  const record={id:Date.now(),date,city,speaker,brand,topic,other,participants,savedAt:new Date().toLocaleString('uk-UA')};

  const btn=document.getElementById('submit-btn');
  btn.disabled=true;btn.textContent='Збереження...';

  let sheetOk=false;
  if(SHEET_URL && SHEET_URL.indexOf('script.google.com')!==-1){
    try{
      for(const p of participants){
        const row={date:formatDate(date),city,speaker,brand,topic,other,name:p.name,phone:p.phone,city_p:p.city,savedAt:record.savedAt};
        await fetch(SHEET_URL,{method:'POST',body:JSON.stringify(row),headers:{'Content-Type':'application/json'},mode:'no-cors'});
      }
      sheetOk=true;
    }catch(e){sheetOk=false;}
  }

  const all=getData();all.unshift(record);saveData(all);

  btn.disabled=false;btn.textContent='Зберегти анкету';
  document.getElementById('error-box').style.display='none';

  let msg=`${participants.length} учасник(ів) · ${formatDate(date)}, ${city}`;
  msg+=sheetOk?' · Збережено в Google Sheets ✓':' · Локальна копія (перевірте налаштування синхронізації)';
  document.getElementById('success-msg').textContent=msg;
  document.getElementById('success').style.display='block';
  setTimeout(()=>document.getElementById('success').style.display='none',6000);

  document.getElementById('date').value='';
  document.getElementById('city').value='';
  document.getElementById('speaker').value='';
  document.getElementById('brand').value='';
  document.getElementById('topic').value='';
  document.getElementById('other').value='';
  document.getElementById('participants-list').innerHTML='';
  pCount=0;updCounter();
}

function showError(msg){
  const el=document.getElementById('error-box');
  el.textContent='⚠️ '+msg;el.style.display='block';
  setTimeout(()=>el.style.display='none',4000);
}

function exportExcel(){
  const all=getData();
  if(!all.length){alert('Немає даних для експорту на цьому пристрої');return;}
  const rows=[['Дата','Місто навчання','Тренер','Бренд','Тема','Інше','ПІБ учасника','Телефон','Місто учасника','Збережено']];
  all.forEach(r=>r.participants.forEach(p=>rows.push([formatDate(r.date),r.city,r.speaker,r.brand,r.topic,r.other||'',p.name||'',p.phone||'',p.city||'',r.savedAt])));
  const ws = XLSX.utils.aoa_to_sheet(rows);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Анкети');
  XLSX.writeFile(wb, 'навчання_'+new Date().toISOString().slice(0,10)+'.xlsx');
}

addP();
</script>
</body>
</html>