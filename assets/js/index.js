
window.onload = function() {
    const colors = ["#f2bbbb", "#ed93cb", "#ca82f8", "#a1d9ff", "#ff9de2", "#8c82fc", "#b693fe", "#7effdb"];
    const divs = document.querySelectorAll(".random-color");
    divs.forEach((div) => {
        const originalText = div.textContent;
        div.innerHTML = "";
        let i = 0;
        while (i < originalText.length) {
            const groupSize = Math.floor(Math.random() * 3) + 1;
            const groupText = originalText.slice(i, i + groupSize);
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            const coloredGroup = `<span style="color: ${randomColor};">${groupText}</span>`;
            div.innerHTML += coloredGroup;
            i += groupSize;
        }
    });
};
function chuangjianxingkong() {
  const huabu = document.createElement('canvas');
  const huabuwenli = huabu.getContext('2d');
  huabu.style.position = 'fixed';
  huabu.style.pointerEvents = 'none';
  document.body.appendChild(huabu);
  
function daxiaogenggai() {
    huabu.width = window.innerWidth;
    huabu.height = window.innerHeight;
  }
  window.addEventListener('resize', daxiaogenggai);
  daxiaogenggai();
  const xingxing = Array.from({length: 200}).map(() => ({
    x: Math.random() * huabu.width,
    y: Math.random() * huabu.height,
    daxiao: Math.random() * 2,
    toumingdu: Math.random()
  }));
function donghua() {
    huabuwenli.clearRect(0, 0, huabu.width, huabu.height);
    huabuwenli.fillStyle = 'rgba(255,255,255,0.8)';
    xingxing.forEach(xing => {
      xing.toumingdu = (xing.toumingdu + 0.01) % 1;
      huabuwenli.beginPath();
      huabuwenli.arc(xing.x, xing.y, xing.daxiao, 0, Math.PI*2);
      huabuwenli.fillStyle = `rgba(255,255,255,${0.5 + Math.sin(xing.toumingdu*Math.PI)*0.5})`;
      huabuwenli.fill();
    });
    requestAnimationFrame(donghua);
  }
  donghua();
}
/* 
过渡效果：
淡入淡出 (fade)
向左滑动 (slideLeft)
向右滑动 (slideRight)
缩放过渡 (zoom)
旋转过渡 (rotate) 
*/ 
function gengghuanbeijing() {
  let dangqianxiangsuoyin = 0;
  const guoduxiaoguo = ['fade', 'slideLeft', 'slideRight', 'zoom', 'rotate']; // 壁纸过渡效果 不需要哪个效果删除即可
  const diannaotupian = [
    'assets/bg-img/pc/1.jpg',
    'assets/bg-img/pc/2.jpg',
    'assets/bg-img/pc/3.jpg',
    'assets/bg-img/pc/4.jpg',
    'assets/bg-img/pc/5.jpg',
    'assets/bg-img/pc/6.jpg',
    'assets/bg-img/pc/7.jpg',
    'assets/bg-img/pc/8.png',
    'assets/bg-img/pc/9.jpg',
    'assets/bg-img/pc/10.jpg',
    'assets/bg-img/pc/11.jpg',
    'assets/bg-img/pc/12.jpg',
    'assets/bg-img/pc/13.jpg',
    'assets/bg-img/pc/14.jpg',
    'assets/bg-img/pc/15.jpg'
  ];
  const shoujituopian = [
    'assets/bg-img/pc/1.jpg',
    'assets/bg-img/pc/2.jpg',
    'assets/bg-img/pc/3.jpg',
    'assets/bg-img/pc/4.jpg',
    'assets/bg-img/pc/5.jpg',
    'assets/bg-img/pc/6.jpg',
    'assets/bg-img/pc/7.jpg',
    'assets/bg-img/pc/8.png',
    'assets/bg-img/pc/9.jpg',
    'assets/bg-img/pc/10.jpg',
    'assets/bg-img/pc/11.jpg',
    'assets/bg-img/pc/12.jpg',
    'assets/bg-img/pc/13.jpg',
    'assets/bg-img/pc/14.jpg',
    'assets/bg-img/pc/15.jpg'
  ];
  const beijingrongqi = document.createElement('div');
  beijingrongqi.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
  `;
  document.body.appendChild(beijingrongqi);
  const beijingceng = [chuangjianceng(), chuangjianceng()];
  let xianzhiceng = 0;

  function chuangjianceng() {
    const ceng = document.createElement('div');
    ceng.style.cssText = `
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      transition: none;
      background-size: cover;
      background-position: center;
    `;
    beijingrongqi.appendChild(ceng);
    return ceng;
  }

  function huodexiayizhang() {
    const shifoushouji = window.matchMedia('(pointer: coarse) and (hover: none)').matches;
    const tupianliebiao = shifoushouji ? shoujituopian : diannaotupian;
    let suijisuoyin;
    do {
      suijisuoyin = Math.floor(Math.random() * tupianliebiao.length);
    } while (suijisuoyin === dangqianxiangsuoyin);
    dangqianxiangsuoyin = suijisuoyin;
    return tupianliebiao[suijisuoyin];
  }
  async function yingyongguodu() {
    const xiatuzhan = huodexiayizhang();
    const dangqianceng = beijingceng[xianzhiceng];
    const xiaceng = beijingceng[1 - xianzhiceng];
    const xiaoguo = guoduxiaoguo[Math.floor(Math.random() * guoduxiaoguo.length)];
    
    xiaceng.style.backgroundImage = `url('${xiatuzhan}')`;
    xiaceng.style.opacity = 0;
    
    await yingyongxiaoguo(dangqianceng, xiaceng, xiaoguo);
    
    xianzhiceng = 1 - xianzhiceng;
  }

  async function yingyongxiaoguo(jiuceng, xinceng, xiaoguo) {
    return new Promise(jiejue => {
      jiuceng.style.transition = 'none';
      xinceng.style.transition = 'none';
      jiuceng.style.transform = '';
      xinceng.style.transform = '';
      
      switch(xiaoguo) {
        case 'fade':
          xinceng.style.opacity = 0;
          break;
        case 'slideLeft':
          xinceng.style.transform = 'translateX(100%)';
          break;
        case 'slideRight':
          xinceng.style.transform = 'translateX(-100%)';
          break;
        case 'zoom':
          xinceng.style.transform = 'scale(1.2)';
          xinceng.style.opacity = 0;
          break;
        case 'rotate':
          xinceng.style.transform = 'rotate(15deg) scale(1.2)';
          xinceng.style.opacity = 0;
          break;
      }

      requestAnimationFrame(() => {
        jiuceng.style.transition = 'all 1.5s ease-in-out';
        xinceng.style.transition = 'all 1.5s ease-in-out';
        
        switch(xiaoguo) {
          case 'fade':
            jiuceng.style.opacity = 0;
            xinceng.style.opacity = 1;
            break;
          case 'slideLeft':
            jiuceng.style.transform = 'translateX(-100%)';
            xinceng.style.transform = 'translateX(0)';
            xinceng.style.opacity = 1;
            break;
          case 'slideRight':
            jiuceng.style.transform = 'translateX(100%)';
            xinceng.style.transform = 'translateX(0)';
            xinceng.style.opacity = 1;
            break;
          case 'zoom':
            jiuceng.style.opacity = 0;
            xinceng.style.transform = 'scale(1)';
            xinceng.style.opacity = 1;
            break;
          case 'rotate':
            jiuceng.style.opacity = 0;
            xinceng.style.transform = 'rotate(0deg) scale(1)';
            xinceng.style.opacity = 1;
            break;
        }
      });

      setTimeout(() => {
        jiuceng.style.transition = 'none';
        jiuceng.style.opacity = 0;
        jiejue();
      }, 1500);
    });
  }
  beijingceng[0].style.backgroundImage = `url('${huodexiayizhang()}')`;
  beijingceng[0].style.opacity = 1;
  setInterval(yingyongguodu, 3500); // 壁纸自动切换时间 单位/毫秒 3500=3.5秒
}

chuangjianxingkong();
gengghuanbeijing();


  $(function() {
    $(".header .openmenu").click(function() {
        $(".header .center").addClass("menuopen");
    });
    $(".header .closemenu").click(function() {
        $(".header .center").removeClass("menuopen");
    });
});

new Vue({
  el: '#app',
  data: function() {
    return { visible: false }
  }
})
function truncateText(divId, maxLength) {
    const div = document.getElementById(divId);
    if (div) {
        let text = div.textContent.trim();
        if (text.length > maxLength) {
            div.textContent = text.substring(0, maxLength) + '...';
        }
    }
}
truncateText('content1', 15);



