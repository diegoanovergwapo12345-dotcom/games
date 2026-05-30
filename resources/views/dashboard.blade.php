@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html,body{margin:0;padding:0;overflow-x:hidden;font-family:system-ui,-apple-system,sans-serif;background:#0a0e1a;color:rgba(255,255,255,0.9);min-height:100vh;}
:root{
    --sidebar-w:260px;
    --topbar-h:65px;
    --accent:#5865F2;
    --pink:#FF2E63;
    --cyan:#08F7FE;
    --surface:rgba(255,255,255,0.04);
    --border:rgba(88,101,242,0.2);
    --text-muted:rgba(255,255,255,0.45);
}
.dashboard{display:flex;min-height:100vh;background:radial-gradient(circle at top left,rgba(88,101,242,0.18),transparent 55%),radial-gradient(circle at bottom right,rgba(255,46,99,0.14),transparent 55%),#0a0e1a;}
.sidebar{
    width:var(--sidebar-w);min-height:100vh;position:fixed;top:0;left:0;z-index:1000;
    backdrop-filter:blur(24px);
    background:rgba(15,23,42,0.97);
    border-right:1px solid rgba(88,101,242,0.25);
    display:flex;flex-direction:column;
    transition:transform 0.4s cubic-bezier(0.4,0,0.2,1);
    box-shadow:4px 0 30px rgba(0,0,0,0.4);
}
.sidebar-brand{padding:24px 20px 20px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between;}
.sidebar-logo{font-size:1.5rem;font-weight:900;background:linear-gradient(135deg,#5865F2 0%,#FF2E63 50%,#08F7FE 100%);-webkit-background-clip:text;background-clip:text;color:transparent;letter-spacing:-0.3px;}
.sidebar-close{display:none;background:none;border:none;color:rgba(255,255,255,0.6);font-size:1.4rem;cursor:pointer;width:36px;height:36px;border-radius:10px;align-items:center;justify-content:center;transition:all 0.2s;}
.sidebar-close:hover{background:rgba(255,255,255,0.08);color:#fff;}
.sidebar-nav{flex:1;padding:16px 12px;display:flex;flex-direction:column;gap:4px;overflow-y:auto;}
.sidebar-nav a{display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:12px;color:rgba(255,255,255,0.75);text-decoration:none;font-weight:500;font-size:0.92rem;transition:all 0.25s ease;position:relative;overflow:hidden;}
.sidebar-nav a i{font-size:1.15rem;flex-shrink:0;transition:transform 0.25s ease;}
.sidebar-nav a:hover{color:#fff;background:rgba(88,101,242,0.12);transform:translateX(4px);}
.sidebar-nav a:hover i{transform:scale(1.15);}
.sidebar-nav a.active{color:#fff;background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(255,46,99,0.15));border-left:3px solid #FF2E63;padding-left:13px;box-shadow:0 4px 20px rgba(88,101,242,0.2);}
.sidebar-footer{padding:16px 12px 20px;border-top:1px solid rgba(255,255,255,0.07);}
.logout-btn{width:100%;background:linear-gradient(135deg,#FF2E63 0%,#08F7FE 100%);border:none;border-radius:12px;padding:13px;font-weight:700;font-size:0.88rem;color:#000;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.3s ease;box-shadow:0 6px 20px rgba(255,46,99,0.3);}
.logout-btn:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(255,46,99,0.45);}
.main{flex:1;margin-left:var(--sidebar-w);display:flex;flex-direction:column;min-height:100vh;transition:margin-left 0.4s cubic-bezier(0.4,0,0.2,1);}
.topbar{position:sticky;top:0;z-index:500;height:var(--topbar-h);backdrop-filter:blur(20px);background:rgba(15,23,42,0.95);border-bottom:1px solid rgba(88,101,242,0.2);display:flex;align-items:center;padding:0 24px;gap:16px;box-shadow:0 4px 20px rgba(0,0,0,0.25);}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:8px;border-radius:10px;border:none;background:rgba(255,255,255,0.06);transition:background 0.2s;}
.hamburger:hover{background:rgba(255,255,255,0.1);}
.hamburger span{width:22px;height:2px;background:#fff;border-radius:2px;transition:all 0.3s ease;display:block;}
.hamburger.active span:nth-child(1){transform:rotate(45deg) translate(5px,5px);}
.hamburger.active span:nth-child(2){opacity:0;}
.hamburger.active span:nth-child(3){transform:rotate(-45deg) translate(5px,-5px);}
.topbar-title{font-size:1.1rem;font-weight:700;color:#fff;flex:1;}
.topbar-actions{display:flex;gap:8px;align-items:center;}
.btn-add{background:linear-gradient(135deg,#5865F2,#FF2E63);border:none;border-radius:10px;padding:9px 20px;font-weight:700;font-size:0.82rem;color:#fff;cursor:pointer;display:flex;align-items:center;gap:7px;transition:all 0.25s;white-space:nowrap;box-shadow:0 4px 18px rgba(88,101,242,0.35);}
.btn-add:hover{transform:translateY(-2px);box-shadow:0 8px 26px rgba(88,101,242,0.5);}
.content{flex:1;padding:28px 24px;display:flex;flex-direction:column;gap:20px;}
.table-card{background:rgba(255,255,255,0.04);border:1px solid rgba(88,101,242,0.2);border-radius:18px;overflow:hidden;box-shadow:0 8px 30px rgba(0,0,0,0.2);animation:cardIn 0.5s ease both;}
.table-card-header{background:linear-gradient(135deg,rgba(88,101,242,0.25),rgba(255,46,99,0.15));border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.table-card-header-left{display:flex;align-items:center;gap:10px;}
.table-card-header h3{font-size:0.88rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;}
.table-card-header i{font-size:1rem;color:rgba(255,255,255,0.7);}
.search-wrap{position:relative;display:flex;align-items:center;}
.search-wrap i{position:absolute;left:13px;color:rgba(255,255,255,0.35);font-size:0.88rem;pointer-events:none;}
.search-input{background:rgba(255,255,255,0.06);border:1px solid rgba(88,101,242,0.22);border-radius:10px;padding:9px 14px 9px 38px;color:#fff;font-size:0.82rem;outline:none;width:220px;transition:all 0.25s;}
.search-input::placeholder{color:rgba(255,255,255,0.3);}
.search-input:focus{border-color:rgba(88,101,242,0.55);background:rgba(255,255,255,0.08);width:260px;box-shadow:0 0 0 3px rgba(88,101,242,0.1);}
.table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;}
.users-table{width:100%;border-collapse:collapse;font-size:0.875rem;}
.users-table thead tr{background:rgba(88,101,242,0.08);border-bottom:1px solid rgba(88,101,242,0.18);}
.users-table thead th{padding:14px 20px;text-align:left;font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,0.4);white-space:nowrap;}
.users-table tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background 0.2s;}
.users-table tbody tr:last-child{border-bottom:none;}
.users-table tbody tr:hover{background:rgba(88,101,242,0.06);}
.users-table td{padding:14px 20px;vertical-align:middle;white-space:nowrap;}
.td-id{color:rgba(255,255,255,0.35);font-size:0.75rem;font-weight:600;font-family:monospace;}
.td-name{display:flex;align-items:center;gap:11px;}
.user-avatar-sm{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden;}
.user-avatar-sm img{width:100%;height:100%;object-fit:cover;border-radius:12px;display:block;}
.avatar-male{background:linear-gradient(135deg,rgba(59,130,246,0.3),rgba(96,165,250,0.2));border:1px solid rgba(59,130,246,0.3);}
.avatar-female{background:linear-gradient(135deg,rgba(255,46,99,0.3),rgba(251,113,133,0.2));border:1px solid rgba(255,46,99,0.3);}
.avatar-other{background:linear-gradient(135deg,rgba(139,92,246,0.3),rgba(167,139,250,0.2));border:1px solid rgba(139,92,246,0.3);}
.name-text{font-weight:600;color:#fff;font-size:0.875rem;}
.td-email{color:rgba(255,255,255,0.55);font-size:0.82rem;}
.gender-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:8px;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;}
.gender-male{background:rgba(59,130,246,0.15);color:#60A5FA;border:1px solid rgba(59,130,246,0.28);}
.gender-female{background:rgba(255,46,99,0.15);color:#FB7185;border:1px solid rgba(255,46,99,0.28);}
.gender-other{background:rgba(139,92,246,0.15);color:#A78BFA;border:1px solid rgba(139,92,246,0.28);}
.role-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:8px;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;}
.role-admin{background:rgba(245,158,11,0.15);color:#FBBF24;border:1px solid rgba(245,158,11,0.28);}
.role-user{background:rgba(148,163,184,0.12);color:#94A3B8;border:1px solid rgba(148,163,184,0.18);}
.status-badge{display:inline-flex;align-items:center;gap:7px;padding:4px 12px;border-radius:8px;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;}
.status-active{background:rgba(16,185,129,0.12);color:#34D399;border:1px solid rgba(16,185,129,0.22);}
.status-active::before{content:'';width:6px;height:6px;border-radius:50%;background:#10B981;box-shadow:0 0 6px rgba(16,185,129,0.7);display:inline-block;animation:pulse 2s infinite;}
.status-inactive{background:rgba(239,68,68,0.12);color:#F87171;border:1px solid rgba(239,68,68,0.22);}
.status-inactive::before{content:'';width:6px;height:6px;border-radius:50%;background:#EF4444;display:inline-block;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:0.4;}}
.action-btns{display:flex;gap:6px;align-items:center;}
.btn-edit{background:rgba(88,101,242,0.12);border:1px solid rgba(88,101,242,0.28);border-radius:9px;padding:6px 13px;color:#818CF8;cursor:pointer;font-size:0.73rem;font-weight:600;display:flex;align-items:center;gap:5px;transition:all 0.2s;}
.btn-edit:hover{background:rgba(88,101,242,0.25);color:#fff;transform:translateY(-1px);box-shadow:0 4px 12px rgba(88,101,242,0.25);}
.btn-delete{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.22);border-radius:9px;padding:6px 13px;color:#F87171;cursor:pointer;font-size:0.73rem;font-weight:600;display:flex;align-items:center;gap:5px;transition:all 0.2s;}
.btn-delete:hover{background:rgba(239,68,68,0.22);color:#fff;transform:translateY(-1px);box-shadow:0 4px 12px rgba(239,68,68,0.2);}
.empty-row td{padding:56px 20px;text-align:center;color:rgba(255,255,255,0.25);font-size:0.9rem;}
.empty-row td i{font-size:2.8rem;display:block;margin-bottom:12px;opacity:0.2;}
.pagination-wrap{padding:18px 24px;border-top:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.page-info{font-size:0.78rem;color:rgba(255,255,255,0.4);}
.page-info span{color:rgba(255,255,255,0.7);font-weight:600;}
.page-links{display:flex;gap:4px;}
.page-links a,.page-links span{display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:9px;font-size:0.8rem;font-weight:600;text-decoration:none;transition:all 0.2s;}
.page-links a{color:rgba(255,255,255,0.55);background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);}
.page-links a:hover{background:rgba(88,101,242,0.18);color:#fff;border-color:rgba(88,101,242,0.35);}
.page-links span.current{background:linear-gradient(135deg,#5865F2,#FF2E63);color:#fff;border:none;box-shadow:0 4px 14px rgba(88,101,242,0.4);}
.page-links span.disabled{color:rgba(255,255,255,0.18);background:transparent;border:1px solid rgba(255,255,255,0.05);cursor:not-allowed;}
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);backdrop-filter:blur(8px);z-index:999;opacity:0;transition:opacity 0.35s ease;}
.overlay.active{display:block;}
.overlay.visible{opacity:1;}

/* ── Modal base ── */
.modal{display:none;position:fixed;inset:0;z-index:1500;align-items:center;justify-content:center;padding:16px;overflow-y:auto;}
.modal.active{display:flex;}
.modal-box{
    backdrop-filter:blur(24px);
    background:rgba(15,23,42,0.98);
    border:1px solid rgba(88,101,242,0.3);
    border-radius:20px;
    width:100%;
    max-width:500px;
    max-height:92vh;
    overflow-y:auto;
    box-shadow:0 30px 80px rgba(0,0,0,0.6),0 0 40px rgba(88,101,242,0.2);
    transform:scale(0.85) translateY(30px);
    opacity:0;
    transition:all 0.4s cubic-bezier(0.4,0,0.2,1);
    margin:auto;
}
.modal-box.open{transform:scale(1) translateY(0);opacity:1;}
.modal-head{padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:1;background:rgba(15,23,42,0.98);}
.modal-head.add-head{background:linear-gradient(135deg,rgba(88,101,242,0.35),rgba(255,46,99,0.2));}
.modal-head.edit-head{background:linear-gradient(135deg,rgba(245,158,11,0.25),rgba(88,101,242,0.2));}
.modal-head.delete-head{background:linear-gradient(135deg,rgba(239,68,68,0.3),rgba(255,46,99,0.18));}
.modal-head.logout-head{background:linear-gradient(135deg,rgba(255,46,99,0.35),rgba(8,247,254,0.2));}
.modal-head h3{font-size:0.95rem;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;display:flex;align-items:center;gap:9px;}
.modal-x{background:none;border:none;color:rgba(255,255,255,0.6);font-size:1.3rem;cursor:pointer;width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;transition:all 0.2s;flex-shrink:0;}
.modal-x:hover{background:rgba(255,255,255,0.1);color:#fff;transform:rotate(90deg);}
.modal-body{padding:24px 20px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-group{display:flex;flex-direction:column;gap:7px;margin-bottom:16px;}
.form-group:last-of-type{margin-bottom:0;}
.form-label{font-size:0.7rem;font-weight:700;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.8px;}
.form-label .optional{font-size:0.68rem;color:rgba(255,255,255,0.28);text-transform:none;letter-spacing:0;font-weight:400;}
.form-input,.form-select{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(88,101,242,0.22);
    border-radius:12px;
    padding:12px 15px;
    color:#fff;
    font-size:0.875rem;
    outline:none;
    transition:all 0.25s;
    width:100%;
    -webkit-appearance:none;
    appearance:none;
}
.form-input::placeholder{color:rgba(255,255,255,0.25);}
.form-input:focus,.form-select:focus{border-color:rgba(88,101,242,0.58);background:rgba(88,101,242,0.08);box-shadow:0 0 0 3px rgba(88,101,242,0.12);}
.form-select{cursor:pointer;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='rgba(255,255,255,0.35)' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;}
.form-select option{background:#0f1726;color:#fff;}
.password-wrap{position:relative;}
.password-wrap .form-input{padding-right:44px;}
.toggle-pw{position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.35);cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;padding:4px;border-radius:6px;transition:color 0.2s;}
.toggle-pw:hover{color:rgba(255,255,255,0.7);}
.pw-strength{height:3px;border-radius:3px;margin-top:7px;background:rgba(255,255,255,0.07);overflow:hidden;}
.pw-strength-bar{height:100%;border-radius:3px;width:0%;transition:width 0.35s ease,background 0.35s ease;}
.pw-hint{font-size:0.71rem;color:rgba(255,255,255,0.3);margin-top:5px;}
.divider{height:1px;background:linear-gradient(90deg,transparent,rgba(88,101,242,0.2),transparent);margin:18px 0;}
.modal-actions{display:flex;gap:10px;margin-top:20px;}
.btn-cancel{flex:1;min-width:100px;background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.12);border-radius:12px;padding:13px;font-weight:700;font-size:0.88rem;color:rgba(255,255,255,0.8);cursor:pointer;transition:all 0.3s;}
.btn-cancel:hover{background:rgba(255,255,255,0.1);color:#fff;}
.btn-save{flex:2;background:linear-gradient(135deg,#5865F2,#FF2E63);border:none;border-radius:12px;padding:13px;font-weight:700;font-size:0.88rem;color:#fff;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 18px rgba(88,101,242,0.32);display:flex;align-items:center;justify-content:center;gap:7px;}
.btn-save:hover{transform:translateY(-2px);box-shadow:0 8px 26px rgba(88,101,242,0.45);}
.btn-delete-confirm{flex:2;background:linear-gradient(135deg,#EF4444,#FF2E63);border:none;border-radius:12px;padding:13px;font-weight:700;font-size:0.88rem;color:#fff;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 16px rgba(239,68,68,0.28);display:flex;align-items:center;justify-content:center;gap:7px;}
.btn-delete-confirm:hover{transform:translateY(-2px);box-shadow:0 8px 26px rgba(239,68,68,0.42);}
.btn-logout-confirm{flex:2;background:linear-gradient(135deg,#FF2E63,#08F7FE);border:none;border-radius:12px;padding:13px;font-weight:700;font-size:0.88rem;color:#000;cursor:pointer;transition:all 0.3s;box-shadow:0 4px 16px rgba(255,46,99,0.28);display:flex;align-items:center;justify-content:center;gap:7px;}
.btn-logout-confirm:hover{transform:translateY(-2px);box-shadow:0 8px 26px rgba(255,46,99,0.42);}
.delete-warning{text-align:center;padding:10px 0 18px;}
.delete-icon-wrap{width:70px;height:70px;border-radius:20px;background:linear-gradient(135deg,rgba(239,68,68,0.2),rgba(255,46,99,0.15));border:1px solid rgba(239,68,68,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:2rem;color:#F87171;}
.delete-warning p{color:rgba(255,255,255,0.85);line-height:1.65;font-size:0.92rem;}
.delete-warning small{color:rgba(255,255,255,0.4);font-size:0.79rem;display:block;margin-top:8px;}
.logout-warning{text-align:center;padding:12px 0 20px;}
.logout-warning .logout-icon{font-size:3rem;background:linear-gradient(135deg,#FF2E63,#08F7FE);-webkit-background-clip:text;background-clip:text;color:transparent;display:block;margin-bottom:14px;}
.logout-warning p{color:rgba(255,255,255,0.85);line-height:1.6;font-size:0.92rem;}
.logout-warning small{color:rgba(255,255,255,0.45);font-size:0.8rem;display:block;margin-top:6px;}
.error-msg{font-size:0.74rem;color:#F87171;display:flex;align-items:center;gap:5px;margin-top:5px;}
.welcome-toast{position:fixed;top:84px;right:20px;background:rgba(15,23,42,0.97);border:1px solid rgba(88,101,242,0.3);backdrop-filter:blur(16px);padding:16px 20px;border-radius:16px;min-width:300px;z-index:99999;transform:translateX(120%);opacity:0;transition:transform 0.5s cubic-bezier(0.4,0,0.2,1),opacity 0.5s ease;box-shadow:0 12px 40px rgba(0,0,0,0.4),0 0 24px rgba(88,101,242,0.2);}
.welcome-toast.show{transform:translateX(0);opacity:1;}
.toast-content{display:flex;align-items:center;gap:14px;}
.toast-icon{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
.toast-icon.success{background:rgba(16,185,129,0.18);color:#34D399;border:1px solid rgba(16,185,129,0.25);}
.toast-icon.error{background:rgba(239,68,68,0.18);color:#F87171;border:1px solid rgba(239,68,68,0.25);}
.toast-text{display:flex;flex-direction:column;gap:3px;}
.toast-text strong{color:#fff;font-size:0.92rem;}
.toast-text span{color:rgba(255,255,255,0.6);font-size:0.82rem;}
@keyframes cardIn{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}

/* ── Mobile cards for table rows ── */
.mobile-card{display:none;}

/* ════════════════════════════════
   RESPONSIVE BREAKPOINTS
   ════════════════════════════════ */

/* Tablet */
@media(max-width:1024px){
    .search-input{width:160px;}
    .search-input:focus{width:200px;}
}

/* Mobile */
@media(max-width:768px){
    /* Sidebar */
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .sidebar-close{display:flex;}
    .main{margin-left:0;}
    .hamburger{display:flex;}

    /* Topbar */
    .topbar{padding:0 14px;gap:10px;}
    .topbar-title{font-size:0.95rem;}
    .btn-add span{display:none;}
    .btn-add{padding:9px 12px;}

    /* Content */
    .content{padding:14px 12px;gap:14px;}

    /* Table card header */
    .table-card-header{padding:12px 14px;gap:8px;}
    .search-input{width:100%;max-width:none;}
    .search-input:focus{width:100%;}
    .search-wrap{width:100%;}
    .table-card-header{flex-direction:column;align-items:stretch;}
    .table-card-header-left{justify-content:space-between;}

    /* Hide desktop table, show mobile cards */
    .table-wrap{display:none;}
    .mobile-card{display:block;padding:10px 12px;}

    .user-card{
        background:rgba(255,255,255,0.04);
        border:1px solid rgba(88,101,242,0.18);
        border-radius:14px;
        padding:14px;
        margin-bottom:10px;
        transition:background 0.2s;
    }
    .user-card:last-child{margin-bottom:0;}
    .user-card-top{display:flex;align-items:center;gap:12px;margin-bottom:12px;}
    .user-card-avatar{width:46px;height:46px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden;}
    .user-card-avatar img{width:100%;height:100%;object-fit:cover;border-radius:11px;display:block;}
    .user-card-info{flex:1;min-width:0;}
    .user-card-name{font-weight:700;color:#fff;font-size:0.92rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .user-card-email{font-size:0.76rem;color:rgba(255,255,255,0.45);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .user-card-badges{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;}
    .user-card-actions{display:flex;gap:8px;}
    .user-card-actions .btn-edit,
    .user-card-actions .btn-delete{flex:1;justify-content:center;padding:9px 10px;font-size:0.78rem;}

    /* Pagination */
    .pagination-wrap{padding:14px;flex-direction:column;align-items:center;gap:10px;}
    .page-info{text-align:center;}

    /* Toast */
    .welcome-toast{top:76px;right:12px;left:12px;min-width:auto;}

    /* ── Modal: slide up from bottom on mobile ── */
    .modal{
        padding:0;
        align-items:flex-end;
        justify-content:center;
    }
    .modal-box{
        max-width:100%;
        width:100%;
        border-radius:22px 22px 0 0;
        max-height:92vh;
        transform:translateY(100%);
        opacity:1;
        margin:0;
    }
    .modal-box.open{
        transform:translateY(0);
        opacity:1;
    }

    /* Modal drag handle */
    .modal-box::before{
        content:'';
        display:block;
        width:40px;
        height:4px;
        background:rgba(255,255,255,0.2);
        border-radius:2px;
        margin:12px auto 0;
    }

    /* Form inside modal */
    .form-row{grid-template-columns:1fr;}
    .modal-body{padding:16px 16px 24px;}
    .modal-head{padding:8px 16px 14px;}
    .modal-head::before{display:none;}

    /* Action buttons stack */
    .modal-actions{flex-direction:column;gap:8px;margin-top:16px;}
    .btn-cancel,
    .btn-save,
    .btn-delete-confirm,
    .btn-logout-confirm{
        width:100%;
        min-width:unset;
        padding:15px;
        font-size:0.95rem;
    }

    /* Inputs larger for touch */
    .form-input,.form-select{
        padding:14px 15px;
        font-size:1rem;
    }
    .form-select{background-position:right 16px center;}
    .password-wrap .form-input{padding-right:48px;}
    .toggle-pw{right:14px;font-size:1.1rem;}

    /* Sidebar footer logout */
    .logout-btn{padding:15px;}
}

/* Small phones */
@media(max-width:380px){
    .topbar-title{font-size:0.85rem;}
    .content{padding:10px 10px;}
    .user-card{padding:12px;}
    .user-card-avatar{width:40px;height:40px;border-radius:10px;}
    .user-card-name{font-size:0.86rem;}
    .modal-head h3{font-size:0.82rem;}
}
</style>

<div class="overlay" id="overlay"></div>

<div class="dashboard">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <span class="sidebar-logo">Pixel Forge</span>
            <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('landing') }}">
                <i class="bi bi-house-door-fill"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
            <a href="{{ route('analytics') }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Analytics</span>
            </a>
            <a href="{{ route('dashboard.index') }}" class="active">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <button class="logout-btn" onclick="openLogoutModal()">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </div>
    </aside>

    <div class="main" id="mainContent">
        <header class="topbar">
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <span class="topbar-title">User Management</span>
            <div class="topbar-actions">
                <button class="btn-add" onclick="openAddModal()">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Add User</span>
                </button>
            </div>
        </header>

        <div class="content">
            <div class="table-card">
                <div class="table-card-header">
                    <div class="table-card-header-left">
                        <i class="bi bi-people-fill"></i>
                        <h3>All Users</h3>
                    </div>
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search users…">
                    </div>
                </div>

                {{-- Desktop table --}}
                <div class="table-wrap">
                    <table class="users-table" id="usersTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($users as $u)
                            @php
                                $avatarFile = !empty($u->avatar) ? 'uploads/' . $u->avatar : null;
                                $hasAvatar  = $avatarFile && Storage::disk('public')->exists($avatarFile);
                                $avatarSrc  = $hasAvatar
                                    ? asset('storage/' . $avatarFile) . '?v=' . Storage::disk('public')->lastModified($avatarFile)
                                    : asset('images/blankpfp.jpg');
                                $initial    = strtoupper(substr($u->name, 0, 1));
                                $gender     = strtolower($u->gender ?? 'other');
                                $avClass    = $gender === 'male' ? 'avatar-male' : ($gender === 'female' ? 'avatar-female' : 'avatar-other');
                            @endphp
                            <tr data-search="{{ strtolower($u->name . ' ' . $u->email . ' ' . $u->role . ' ' . ($u->gender ?? '') . ' ' . ($u->status ?? '')) }}">
                                <td class="td-id">{{ $u->id }}</td>
                                <td>
                                    <div class="td-name">
                                        <div class="user-avatar-sm {{ $avClass }}" id="av-tbl-{{ $u->id }}">
                                            <img src="{{ $avatarSrc }}"
                                                 alt="{{ $u->name }}"
                                                 onerror="this.remove(); document.getElementById('av-tbl-{{ $u->id }}').textContent='{{ $initial }}'">
                                        </div>
                                        <span class="name-text">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="td-email">{{ $u->email }}</td>
                                <td>
                                    @if($gender === 'male')
                                        <span class="gender-badge gender-male"><i class="bi bi-gender-male"></i>Male</span>
                                    @elseif($gender === 'female')
                                        <span class="gender-badge gender-female"><i class="bi bi-gender-female"></i>Female</span>
                                    @else
                                        <span class="gender-badge gender-other"><i class="bi bi-gender-ambiguous"></i>Other</span>
                                    @endif
                                </td>
                                <td>
                                    @if(strtolower($u->role) === 'admin')
                                        <span class="role-badge role-admin"><i class="bi bi-shield-fill"></i>Admin</span>
                                    @else
                                        <span class="role-badge role-user"><i class="bi bi-person-fill"></i>User</span>
                                    @endif
                                </td>
                                <td>
                                    @if(($u->status ?? 'active') === 'active')
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-edit" onclick='openEditModal(@json($u))'>
                                            <i class="bi bi-pencil-fill"></i>Edit
                                        </button>
                                        <button class="btn-delete" onclick="openDeleteModal({{ $u->id }}, '{{ addslashes($u->name) }}')">
                                            <i class="bi bi-trash-fill"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="empty-row">
                                <td colspan="7">
                                    <i class="bi bi-people"></i>
                                    No users found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards --}}
                <div class="mobile-card" id="mobileCards">
                    @forelse($users as $u)
                    @php
                        $avatarFile = !empty($u->avatar) ? 'uploads/' . $u->avatar : null;
                        $hasAvatar  = $avatarFile && Storage::disk('public')->exists($avatarFile);
                        $avatarSrc  = $hasAvatar
                            ? asset('storage/' . $avatarFile) . '?v=' . Storage::disk('public')->lastModified($avatarFile)
                            : asset('images/blankpfp.jpg');
                        $initial    = strtoupper(substr($u->name, 0, 1));
                        $gender     = strtolower($u->gender ?? 'other');
                        $avClass    = $gender === 'male' ? 'avatar-male' : ($gender === 'female' ? 'avatar-female' : 'avatar-other');
                    @endphp
                    <div class="user-card"
                         data-search="{{ strtolower($u->name . ' ' . $u->email . ' ' . $u->role . ' ' . ($u->gender ?? '') . ' ' . ($u->status ?? '')) }}">
                        <div class="user-card-top">
                            <div class="user-card-avatar {{ $avClass }}" id="av-mob-{{ $u->id }}">
                                <img src="{{ $avatarSrc }}"
                                     alt="{{ $u->name }}"
                                     onerror="this.remove(); document.getElementById('av-mob-{{ $u->id }}').textContent='{{ $initial }}'">
                            </div>
                            <div class="user-card-info">
                                <div class="user-card-name">{{ $u->name }}</div>
                                <div class="user-card-email">{{ $u->email }}</div>
                            </div>
                        </div>
                        <div class="user-card-badges">
                            @if($gender === 'male')
                                <span class="gender-badge gender-male"><i class="bi bi-gender-male"></i>Male</span>
                            @elseif($gender === 'female')
                                <span class="gender-badge gender-female"><i class="bi bi-gender-female"></i>Female</span>
                            @else
                                <span class="gender-badge gender-other"><i class="bi bi-gender-ambiguous"></i>Other</span>
                            @endif

                            @if(strtolower($u->role) === 'admin')
                                <span class="role-badge role-admin"><i class="bi bi-shield-fill"></i>Admin</span>
                            @else
                                <span class="role-badge role-user"><i class="bi bi-person-fill"></i>User</span>
                            @endif

                            @if(($u->status ?? 'active') === 'active')
                                <span class="status-badge status-active">Active</span>
                            @else
                                <span class="status-badge status-inactive">Inactive</span>
                            @endif
                        </div>
                        <div class="user-card-actions">
                            <button class="btn-edit" onclick='openEditModal(@json($u))'>
                                <i class="bi bi-pencil-fill"></i>Edit
                            </button>
                            <button class="btn-delete" onclick="openDeleteModal({{ $u->id }}, '{{ addslashes($u->name) }}')">
                                <i class="bi bi-trash-fill"></i>Delete
                            </button>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;padding:48px 20px;color:rgba(255,255,255,0.25);">
                        <i class="bi bi-people" style="font-size:2.8rem;display:block;margin-bottom:12px;opacity:0.2;"></i>
                        No users found
                    </div>
                    @endforelse
                </div>

                @if(method_exists($users, 'links'))
                <div class="pagination-wrap">
                    <div class="page-info">
                        Showing <span>{{ $users->firstItem() }}–{{ $users->lastItem() }}</span> of <span>{{ $users->total() }}</span> users
                    </div>
                    <div class="page-links">
                        @if($users->onFirstPage())
                            <span class="disabled"><i class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                        @endif
                        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if($page == $users->currentPage())
                                <span class="current">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                        @else
                            <span class="disabled"><i class="bi bi-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal" id="addModal">
    <div class="modal-box" id="addBox">
        <div class="modal-head add-head">
            <h3><i class="bi bi-person-plus-fill"></i>Add New User</h3>
            <button class="modal-x" onclick="closeModal('addModal','addBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('dashboard.store') }}" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled selected>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="" disabled selected>Select role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="divider"></div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrap">
                        <input type="password" name="password" class="form-input" id="addPassword" placeholder="Min. 8 characters" required oninput="checkStrength(this,'addBar','addHint')">
                        <button type="button" class="toggle-pw" onclick="togglePw('addPassword',this)"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="pw-strength"><div class="pw-strength-bar" id="addBar"></div></div>
                    <div class="pw-hint" id="addHint">Enter a strong password</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="password-wrap">
                        <input type="password" name="password_confirmation" class="form-input" id="addPasswordConfirm" placeholder="Repeat password" required oninput="checkMatch('addPassword','addPasswordConfirm','addMatchMsg')">
                        <button type="button" class="toggle-pw" onclick="togglePw('addPasswordConfirm',this)"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="error-msg" id="addMatchMsg" style="display:none;"><i class="bi bi-exclamation-circle"></i>Passwords do not match</div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('addModal','addBox')">Cancel</button>
                    <button type="submit" class="btn-save"><i class="bi bi-person-plus-fill"></i>Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal" id="editModal">
    <div class="modal-box" id="editBox">
        <div class="modal-head edit-head">
            <h3><i class="bi bi-pencil-fill"></i>Edit User</h3>
            <button class="modal-x" onclick="closeModal('editModal','editBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <form method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-input" id="editName" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" id="editEmail" placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" id="editGender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" id="editRole" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="editStatus" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="divider"></div>
                <div class="form-group">
                    <label class="form-label">New Password <span class="optional">(leave blank to keep current)</span></label>
                    <div class="password-wrap">
                        <input type="password" name="password" class="form-input" id="editPassword" placeholder="New password" oninput="checkStrength(this,'editBar','editHint')">
                        <button type="button" class="toggle-pw" onclick="togglePw('editPassword',this)"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="pw-strength"><div class="pw-strength-bar" id="editBar"></div></div>
                    <div class="pw-hint" id="editHint">Leave blank to keep current password</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <div class="password-wrap">
                        <input type="password" name="password_confirmation" class="form-input" id="editPasswordConfirm" placeholder="Repeat new password" oninput="checkMatch('editPassword','editPasswordConfirm','editMatchMsg')">
                        <button type="button" class="toggle-pw" onclick="togglePw('editPasswordConfirm',this)"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="error-msg" id="editMatchMsg" style="display:none;"><i class="bi bi-exclamation-circle"></i>Passwords do not match</div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('editModal','editBox')">Cancel</button>
                    <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal" id="deleteModal">
    <div class="modal-box" id="deleteBox">
        <div class="modal-head delete-head">
            <h3><i class="bi bi-trash-fill"></i>Delete User</h3>
            <button class="modal-x" onclick="closeModal('deleteModal','deleteBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <div class="delete-warning">
                <div class="delete-icon-wrap"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <p>You are about to delete <strong id="deleteUserName"></strong>.</p>
                <small>This action cannot be undone. All data for this user will be permanently removed.</small>
            </div>
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
            </form>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('deleteModal','deleteBox')">Cancel</button>
                <button type="button" class="btn-delete-confirm" onclick="document.getElementById('deleteForm').submit()">
                    <i class="bi bi-trash-fill"></i>Delete
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Logout Modal --}}
<div class="modal" id="logoutModal">
    <div class="modal-box" id="logoutBox">
        <div class="modal-head logout-head">
            <h3><i class="bi bi-box-arrow-left"></i>Confirm Logout</h3>
            <button class="modal-x" onclick="closeModal('logoutModal','logoutBox')">&#10005;</button>
        </div>
        <div class="modal-body">
            <div class="logout-warning">
                <i class="bi bi-box-arrow-left logout-icon"></i>
                <p>Are you sure you want to log out of <strong>Pixel Forge</strong>?</p>
                <small>You will need to sign in again to access your account.</small>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
            </form>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('logoutModal','logoutBox')">Stay</button>
                <button type="button" class="btn-logout-confirm" onclick="document.getElementById('logoutForm').submit()">
                    <i class="bi bi-box-arrow-left"></i>Logout
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const hamburger    = document.getElementById('hamburger');
    const sidebar      = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const overlay      = document.getElementById('overlay');

    function openSidebar() {
        sidebar.classList.add('open');
        hamburger.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => overlay.classList.add('visible'));
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        hamburger.classList.remove('active');
        overlay.classList.remove('visible');
        document.body.style.overflow = '';
        setTimeout(() => overlay.classList.remove('active'), 350);
    }

    hamburger?.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
    sidebarClose?.addEventListener('click', closeSidebar);

    overlay?.addEventListener('click', () => {
        closeSidebar();
        ['addModal','editModal','deleteModal','logoutModal'].forEach(id => {
            if (document.getElementById(id)?.classList.contains('active')) {
                closeModal(id, id.replace('Modal','Box'));
            }
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeSidebar();
            ['addModal','editModal','deleteModal','logoutModal'].forEach(id => {
                if (document.getElementById(id)?.classList.contains('active')) {
                    closeModal(id, id.replace('Modal','Box'));
                }
            });
        }
    });

    // Search — targets both table rows and mobile cards
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase().trim();
        document.querySelectorAll('#tableBody tr[data-search]').forEach(row => {
            row.style.display = row.dataset.search.includes(q) ? '' : 'none';
        });
        document.querySelectorAll('#mobileCards .user-card[data-search]').forEach(card => {
            card.style.display = card.dataset.search.includes(q) ? '' : 'none';
        });
    });

    @if(session('success'))
    showToast('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
    showToast('{{ session('error') }}', 'error');
    @endif

    @if($errors->any())
    showToast('{{ $errors->first() }}', 'error');
    @endif
});

function openModal(modalId, boxId) {
    const modal   = document.getElementById(modalId);
    const box     = document.getElementById(boxId);
    const overlay = document.getElementById('overlay');
    modal.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => {
        overlay.classList.add('visible');
        requestAnimationFrame(() => box.classList.add('open'));
    });
}

function closeModal(modalId, boxId) {
    const modal   = document.getElementById(modalId);
    const box     = document.getElementById(boxId);
    const overlay = document.getElementById('overlay');
    box.classList.remove('open');
    overlay.classList.remove('visible');
    setTimeout(() => {
        modal.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }, 400);
}

function openAddModal() {
    document.getElementById('addForm').reset();
    document.getElementById('addBar').style.width = '0%';
    document.getElementById('addHint').textContent = 'Enter a strong password';
    document.getElementById('addMatchMsg').style.display = 'none';
    openModal('addModal', 'addBox');
}

function openEditModal(user) {
    document.getElementById('editForm').action = '/dashboard/' + user.id;
    document.getElementById('editName').value   = user.name   || '';
    document.getElementById('editEmail').value  = user.email  || '';
    document.getElementById('editGender').value = (user.gender || 'other').toLowerCase();
    document.getElementById('editRole').value   = (user.role   || 'user').toLowerCase();
    document.getElementById('editStatus').value = user.status  || 'active';
    document.getElementById('editPassword').value = '';
    document.getElementById('editPasswordConfirm').value = '';
    document.getElementById('editBar').style.width = '0%';
    document.getElementById('editHint').textContent = 'Leave blank to keep current password';
    document.getElementById('editMatchMsg').style.display = 'none';
    openModal('editModal', 'editBox');
}

function openDeleteModal(id, name) {
    document.getElementById('deleteForm').action = '/dashboard/' + id;
    document.getElementById('deleteUserName').textContent = name;
    openModal('deleteModal', 'deleteBox');
}

function openLogoutModal() {
    openModal('logoutModal', 'logoutBox');
}

function togglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

function checkStrength(input, barId, hintId) {
    const val  = input.value;
    const bar  = document.getElementById(barId);
    const hint = document.getElementById(hintId);
    let score  = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        {w:'0%',   c:'transparent', t:'Enter a strong password'},
        {w:'25%',  c:'#EF4444',     t:'Weak'},
        {w:'50%',  c:'#F59E0B',     t:'Fair'},
        {w:'75%',  c:'#3B82F6',     t:'Good'},
        {w:'100%', c:'#10B981',     t:'Strong'},
    ];
    const lvl = val.length === 0 ? levels[0] : levels[score];
    bar.style.width      = lvl.w;
    bar.style.background = lvl.c;
    hint.textContent     = val.length === 0
        ? (input.id.includes('edit') ? 'Leave blank to keep current password' : 'Enter a strong password')
        : lvl.t;
}

function checkMatch(pwId, confirmId, msgId) {
    const pw      = document.getElementById(pwId).value;
    const confirm = document.getElementById(confirmId).value;
    const msg     = document.getElementById(msgId);
    msg.style.display = (confirm.length > 0 && pw !== confirm) ? 'flex' : 'none';
}

document.getElementById('addForm')?.addEventListener('submit', function(e) {
    const pw      = document.getElementById('addPassword').value;
    const confirm = document.getElementById('addPasswordConfirm').value;
    if (pw !== confirm) {
        e.preventDefault();
        document.getElementById('addMatchMsg').style.display = 'flex';
    }
});

document.getElementById('editForm')?.addEventListener('submit', function(e) {
    const pw      = document.getElementById('editPassword').value;
    const confirm = document.getElementById('editPasswordConfirm').value;
    if (pw && pw !== confirm) {
        e.preventDefault();
        document.getElementById('editMatchMsg').style.display = 'flex';
    }
});

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = 'welcome-toast';
    const iconClass = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
    const label     = type === 'success' ? 'Success' : 'Error';
    toast.innerHTML = `<div class="toast-content"><div class="toast-icon ${type}"><i class="bi ${iconClass}"></i></div><div class="toast-text"><strong>${label}</strong><span>${message}</span></div></div>`;
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 4000);
}
</script>
@endsection