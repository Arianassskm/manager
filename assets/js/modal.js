// modal.js
(() => {
    // 默认配置
    const defaultConfig = {
        background: 'rgba(0,0,0,0.8)', // 背景颜色
        blurStrength: '10px', // 模糊强度
        fadeDuration: '0.3s', // 动画时间
        zIndex: 2147483647, // z-index
        autoShow: false, // 是否自动显示
        autoHide: false, // 是否自动隐藏
        showDelay: 0, // 自动显示延迟
        hideDelay: 8000 // 自动隐藏延迟
    };
    const modalScript = document.currentScript;
    const userConfig = {
        background: modalScript.getAttribute('data-background'),
        blurStrength: modalScript.getAttribute('data-blur'),
        fadeDuration: modalScript.getAttribute('data-fade-duration'),
        zIndex: modalScript.getAttribute('data-zindex'),
        autoShow: modalScript.getAttribute('data-auto-show'),
        autoHide: modalScript.getAttribute('data-auto-hide'),
        showDelay: modalScript.getAttribute('data-show-delay'),
        hideDelay: modalScript.getAttribute('data-hide-delay')
    };
    const config = {
        ...defaultConfig,
        ...Object.fromEntries(
            Object.entries(userConfig)
                .filter(([_, value]) => value !== null)
                .map(([key, value]) => [key, key === 'zIndex' || key.endsWith('Delay') ? Number(value) : value])
        )
    };
    const modalId = 'dynamic-modal-' + Math.random().toString(36).substr(2, 9);
    const style = document.createElement('style');
    style.textContent = `
        [data-modal="${modalId}"] {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: ${config.background};
            backdrop-filter: blur(${config.blurStrength});
            -webkit-backdrop-filter: blur(${config.blurStrength});
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity ${config.fadeDuration} ease-out, visibility ${config.fadeDuration};
            z-index: ${config.zIndex};
            padding: 20px;
            box-sizing: border-box;
        }
        [data-modal="${modalId}"][data-active] {
            opacity: 1;
            visibility: visible;
        }
        [data-modal="${modalId}"] .modal-content {
            background: #fff;
            border-radius: 8px;
            max-width: 90%;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        [data-modal="${modalId}"] .modal-header {
            padding: 16px;
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
            font-size: 18px;
            font-weight: bold;
        }
        [data-modal="${modalId}"] .modal-body {
            padding: 16px;
            max-height: 60vh;
            overflow-y: auto;
        }
        [data-modal="${modalId}"] .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        [data-modal="${modalId}"] .modal-close:hover {
            background: rgba(255,255,255,1);
            transform: scale(1.1);
        }
    `;
    document.head.appendChild(style);
    const modal = document.createElement('div');
    modal.setAttribute('data-modal', modalId);
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body"></div>
        </div>
        <div class="modal-close">&times;</div>
    `;
    document.body.appendChild(modal);
    const show = (content, title = '') => {
        if (!content) return;
        if (title) modal.querySelector('.modal-header').textContent = title;
        modal.querySelector('.modal-body').innerHTML = content;
        modal.setAttribute('data-active', '');
        if (config.autoHide) {
            setTimeout(hide, config.hideDelay);
        }
    };
    const hide = () => {
        modal.removeAttribute('data-active');
    };
    modal.querySelector('.modal-close').addEventListener('click', hide);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) hide();
    });
    if (config.autoShow) {
        const content = document.querySelector(config.autoShow)?.innerHTML || '';
        if (content) {
            setTimeout(() => show(content), config.showDelay);
        }
    }
    window.DynamicModal = {
        show: (content, title, options = {}) => {
            if (!content) return;
            Object.assign(config, options);
            show(content, title);
        },
        hide,
        updateConfig: (newConfig) => {
            Object.assign(config, newConfig);
            style.textContent = style.textContent;
        }
    };
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-modal-trigger]');
        if (trigger) {
            const content = document.querySelector(trigger.dataset.modalContent)?.innerHTML || '';
            if (!content) return;
            const title = trigger.dataset.modalTitle || '';
            DynamicModal.show(content, title);
        }
    });
})();