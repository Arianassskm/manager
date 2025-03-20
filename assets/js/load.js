(() => {
    const defaultConfig = {
        background: 'rgba(255,255,255,0.7)',
        blurStrength: '10px',
        spinnerColor: 'rgba(0,0,0,0.6)',
        fadeDuration: '0.4s',
        zIndex: 2147483647,
        mode: 1
    };
    const loaderScript = document.currentScript;
    const userConfig = {
        background: loaderScript.getAttribute('data-background'),
        blurStrength: loaderScript.getAttribute('data-blur'),
        spinnerColor: loaderScript.getAttribute('data-spinner-color'),
        fadeDuration: loaderScript.getAttribute('data-fade-duration'),
        zIndex: loaderScript.getAttribute('data-zindex'),
        mode: loaderScript.getAttribute('data-mode')
    };
    const config = {
        ...defaultConfig,
        ...Object.fromEntries(
            Object.entries(userConfig)
                .filter(([_, value]) => value !== null)
        )
    };
    const loaderId = 'dynamic-loader-' + Math.random().toString(36).substr(2, 9);
    const style = document.createElement('style');
    style.textContent = `
        [data-loader="${loaderId}"] {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: ${config.background};
            backdrop-filter: blur(${config.blurStrength}) saturate(180%);
            -webkit-backdrop-filter: blur(${config.blurStrength}) saturate(180%);
            display: grid;
            place-items: center;
            opacity: 0;
            transition: opacity ${config.fadeDuration} ease-out;
            z-index: ${config.zIndex};
            pointer-events: none;
        }
        
        [data-loader="${loaderId}"][data-active] {
            opacity: 1;
            pointer-events: all;
        }
        
        [data-loader="${loaderId}"]::after {
            content: '';
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: ${config.spinnerColor};
            border-radius: 50%;
            animation: ${loaderId}-spin 1s linear infinite;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        @keyframes ${loaderId}-spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    const loader = document.createElement('div');
    loader.setAttribute('data-loader', loaderId);
    document.body.prepend(loader);
    const show = () => {
        loader.setAttribute('data-active', '');
        calculateDuration(config.mode);
    };
    const calculateDuration = (mode) => {
        let duration = 0;
        switch(Number(mode)) {
            case 1:
                const timing = performance.timing;
                duration = timing.loadEventEnd - timing.navigationStart;
                duration = Math.max(duration, 0);
                break;
                
            case 2:
                duration = 1000;
                break;
                
            case 3:
                duration = 3000 + Math.random() * 2000;
                break;
        }
        setTimeout(() => {
            loader.removeAttribute('data-active');
            loader.addEventListener('transitionend', () => {
                loader.remove();
                style.remove();
            }, { once: true });
        }, duration);
    };
    if (document.readyState === 'complete') {
        show();
    } else {
        window.addEventListener('load', show);
    }
    window.DynamicLoader = {
        show: (mode = config.mode) => {
            show();
            calculateDuration(mode);
        },
        hide: () => {
            loader.removeAttribute('data-active');
            loader.addEventListener('transitionend', () => {
                loader.remove();
                style.remove();
            }, { once: true });
        },
        updateConfig: (newConfig) => {
            Object.assign(config, newConfig);
            style.textContent = style.textContent; // 触发样式更新
        }
    };
})();