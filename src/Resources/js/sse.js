function SseConnect(e){let t=new EventSource(e);t.addEventListener("close",e=>{JSON.parse(e.data).reload&&window.location.reload()}),t.addEventListener("messageSweet",e=>{let t=JSON.parse(e.data),n="success";"error"===t.type&&(n="error"),"info"===t.type&&(n="info"),"warning"===t.type&&(n="warning"),"question"===t.type&&(n="question"),t.confirm?Swal.fire({title:t.title,text:t.message,icon:n}):Swal.fire({position:"top-end",icon:n,title:t.title,text:t.message,showConfirmButton:!1,timer:1500})}),t.addEventListener("messageAlert",e=>{alert(JSON.parse(e.data).message)}),t.addEventListener("messageToast",e=>{let t=JSON.parse(e.data),n=loadBoxMessage();document.getElementsByTagName("body")[0].append(n);let a=loadToast(t);n.append(a),$("#"+t.id).fadeIn(),t.autoClose&&setTimeout(function(){$("#"+t.id).fadeOut("slow",function(){document.getElementById(t.id).remove()})},1e4)}),t.addEventListener("messageNotify",e=>{let t=JSON.parse(e.data),n=loadBoxMessage();document.getElementsByTagName("body")[0].append(n);let a=loadNotify(t.id,t.title,t.message,t.date,t.type);n.append(a),$("#"+t.id).fadeIn(),t.autoClose&&setTimeout(function(){$("#"+t.id).fadeOut("slow",function(){document.getElementById(t.id).remove()})},1e4)}),t.addEventListener("injectionHtml",e=>{let t=JSON.parse(e.data),n=document.getElementById(t.target);if(t.append){let a=document.createElement("div");a.innerHTML=t.html,n.insertAdjacentElement("beforeend",a)}else n.innerHTML=t.html}),t.addEventListener("injectionScript",e=>{let t=JSON.parse(e.data),n=document.getElementsByTagName("body")[0],a=document.getElementById("box-sse-script");a&&a.remove();let l=document.createElement("script");l.id="box-sse-script",l.textContent=t.script,n.appendChild(l)})}function loadNotify(e,t,n,a,l){let i="#155724",r="#d4edda",s="#c3e6cb";"error"===l&&(i="#721c24",r="#f8d7da",s="#f5c6cb"),"info"===l&&(i="#0c5460",r="#d1ecf1",s="#bee5eb"),"warning"===l&&(i="#856404",r="#fff3cd",s="#ffeeba"),"question"===l&&(i="#004085",r="#cce5ff",s="#b8daff");let o=document.createElement("div");o.setAttribute("role","alert"),o.setAttribute("aria-live","assertive"),o.setAttribute("aria-atomic","true"),o.setAttribute("id",e),o.style.width="500px",o.style.minHeight="50px",o.style.backgroundColor=r,o.style.border="1px solid "+s,o.style.borderRadius="5px",o.style.boxShadow="rgba(0, 0, 0, 0.1) 0px 0.25rem 0.75rem",o.style.marginBottom="10px",o.style.marginTop="10px";let d=document.createElement("div");d.style.borderBottom="1px solid "+s,d.style.padding="10px";let p=document.createElement("strong");p.style.color=i,p.style.fontSize="14px",p.innerHTML=t,d.append(p);let y=document.createElement("button");y.setAttribute("type","button"),y.setAttribute("data-dismiss","notify"),y.setAttribute("aria-label","Close"),y.style.float="right",y.style.fontSize="24px",y.style.lineHeight="1",y.style.color=i,y.style.textShadow="rgb(255, 255, 255) 0px 1px 0px",y.style.marginLeft="20px",y.style.padding="0px",y.style.backgroundColor="transparent",y.style.border="0px",y.style.appearance="none",y.onclick=function(){document.getElementById(e).remove()},y.innerHTML="&times;",d.append(y),o.append(d);let m=document.createElement("div");return m.style.color=i,m.style.fontSize="12px",m.style.padding="10px",m.innerHTML=n,o.append(m),o}function loadBoxMessage(){let e=document.getElementById("box-message");return null===e&&((e=document.createElement("div")).setAttribute("id","box-message"),e.style.position="fixed",e.style.top="20px",e.style.right="20px",e.style.zIndex="9999"),e}function loadToast(e){let t="#155724",n="#d4edda",a="#c3e6cb";"error"===e.type&&(t="#721c24",n="#f8d7da",a="#f5c6cb"),"info"===e.type&&(t="#0c5460",n="#d1ecf1",a="#bee5eb"),"warning"===e.type&&(t="#856404",n="#fff3cd",a="#ffeeba"),"question"===e.type&&(t="#004085",n="#cce5ff",a="#b8daff");let l=document.createElement("div");l.setAttribute("role","alert"),l.setAttribute("aria-live","assertive"),l.setAttribute("aria-atomic","true"),l.setAttribute("id",e.id),l.style.maxWidth="350px",l.style.overflow="hidden",l.style.position="relative",l.style.fontSize="0.875rem",l.style.backgroundColor=n,l.style.border="1px solid "+a,l.style.borderRadius="0.25rem",l.style.boxShadow="rgba(0, 0, 0, 0.1) 0px 0.25rem 0.75rem",l.style.backdropFilter="blur(10px)",l.style.marginBottom="20px",l.style.display="none",l.style.minWidth="350px";let i=document.createElement("div");i.style.padding="0.5rem 0.75rem",i.style.borderBottom="1px solid rgba(0, 0, 0, 0.1)",i.style.backgroundColor="rgba(240, 240, 240, 0.3)",i.style.backgroundClip="padding-box",i.style.color=t;let r=document.createElement("img");r.style.borderRadius="0.25rem !important",r.setAttribute("alt","..."),r.setAttribute("src",e.imgURL??"/assets/images/logo.png"),r.style.width="30px",r.fontSize="1.125rem",r.style.textAnchor="middle",r.marginRight="10px";let s=document.createElement("strong");s.innerHTML=e.title,s.style.boxSizing="border-box",s.style.fontWeight="bolder",s.style.marginRight="auto !important",s.style.marginLeft="10px";let o=document.createElement("small");o.style.float="right",o.style.fontSize="8px",o.style.marginTop="7px",o.innerHTML=e.date;let d=document.createElement("button");d.setAttribute("type","button"),d.setAttribute("data-dismiss","toast"),d.setAttribute("aria-label","Close"),d.style.float="right",d.style.fontSize="1.5rem",d.style.fontWeight="700",d.style.lineHeight="1",d.style.color=t,d.style.textShadow="rgb(255, 255, 255) 0px 1px 0px",d.style.opacity="0.5",d.style.marginLeft="20px",d.style.padding="0px",d.style.backgroundColor="transparent",d.style.border="0px",d.style.appearance="none",d.onclick=function(){document.getElementById(id).remove()};let p=document.createElement("span");p.setAttribute("aria-hidden","true"),p.innerHTML="&times;",d.append(p),i.append(r),i.append(s),i.append(d),i.append(o);let y=document.createElement("div");if(y.className="toast-body",y.style.padding="10px",y.style.color=t,null!==e.linkURL){let m=document.createElement("a");m.setAttribute("href",e.linkURL),m.innerHTML=" "+(e.linkText??"Link")+" ";let c=e.message.split("[link]");y.append(c[0]),y.append(m),c[1]&&y.append(c[1])}else y.innerHTML=e.message;return l.append(i),l.append(y),l}
