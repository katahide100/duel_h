/**
 * <select multiple> をタグ(バッジ)入力に変える。
 *
 * OSの複数選択セレクトは Ctrl を押さずにクリックすると選択が全部消えるため、
 * 効果や種族のように「既に何個か選んでいて、そこに足したい」編集で事故りやすい。
 *
 * 作りの方針（プログレッシブ・エンハンスメント）:
 *   - 元の <select multiple> はそのまま残し、値の保持は option.selected だけで行う。
 *     → CakePHP のフォームバインドと POST 形式(data[Card][effects][])は変更なし。
 *     → この JS が読み込まれなければ、従来どおりの複数選択セレクトとして動く。
 *   - 対象は data-tagselect 属性が付いた select。
 *
 * 操作:
 *   - 入力欄に文字を打つと候補を絞り込み、クリック/Enter で追加
 *   - バッジの × か、入力が空の状態で Backspace で削除
 *   - ↑↓ で候補を移動、Esc で候補を閉じる
 */
(function () {
  'use strict';

  function enhance(select) {
    if (select.dataset.tagselectReady === '1') {
      return;
    }
    select.dataset.tagselectReady = '1';

    var options = Array.prototype.slice.call(select.options).filter(function (option) {
      // 「以下より選択」のような空の option は候補に入れない
      return option.value !== '';
    });

    var root = document.createElement('div');
    root.className = 'tagselect';

    var box = document.createElement('div');
    box.className = 'tagselect-box';

    var input = document.createElement('input');
    input.type = 'text';
    input.className = 'tagselect-input';
    input.autocomplete = 'off';
    input.placeholder = select.dataset.tagselectPlaceholder || '入力して絞り込み / クリックで追加';

    var list = document.createElement('ul');
    list.className = 'tagselect-list';

    box.appendChild(input);
    root.appendChild(box);
    root.appendChild(list);

    select.parentNode.insertBefore(root, select);
    root.appendChild(select);
    select.classList.add('tagselect-source');

    var activeIndex = -1;

    function selectedOptions() {
      return options.filter(function (option) {
        return option.selected;
      });
    }

    function renderBadges() {
      Array.prototype.slice.call(box.querySelectorAll('.tagselect-badge')).forEach(function (badge) {
        box.removeChild(badge);
      });
      selectedOptions().forEach(function (option) {
        var badge = document.createElement('span');
        badge.className = 'tagselect-badge';
        badge.textContent = option.text;

        var remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'tagselect-remove';
        remove.textContent = '×';
        remove.setAttribute('aria-label', option.text + ' を外す');
        remove.addEventListener('click', function () {
          option.selected = false;
          render();
          input.focus();
        });

        badge.appendChild(remove);
        box.insertBefore(badge, input);
      });
    }

    function candidates() {
      var keyword = input.value.trim().toLowerCase();
      return options.filter(function (option) {
        if (option.selected) {
          return false;
        }
        if (keyword === '') {
          return true;
        }
        return (
          option.text.toLowerCase().indexOf(keyword) !== -1 ||
          option.value.toLowerCase().indexOf(keyword) !== -1
        );
      });
    }

    function renderList() {
      list.innerHTML = '';
      if (!root.classList.contains('is-open')) {
        return;
      }
      var items = candidates();
      if (items.length === 0) {
        var empty = document.createElement('li');
        empty.className = 'tagselect-empty';
        empty.textContent = '候補がありません';
        list.appendChild(empty);
        return;
      }
      if (activeIndex >= items.length) {
        activeIndex = items.length - 1;
      }
      items.forEach(function (option, index) {
        var item = document.createElement('li');
        item.className = 'tagselect-item' + (index === activeIndex ? ' is-active' : '');
        item.textContent = option.text + '（' + option.value + '）';
        // mousedown で処理する（click だと input の blur が先に走って一覧が閉じる）
        item.addEventListener('mousedown', function (e) {
          e.preventDefault();
          add(option);
        });
        list.appendChild(item);
      });
    }

    function render() {
      renderBadges();
      renderList();
    }

    function open() {
      root.classList.add('is-open');
      renderList();
    }

    function close() {
      root.classList.remove('is-open');
      activeIndex = -1;
      renderList();
    }

    function add(option) {
      option.selected = true;
      input.value = '';
      activeIndex = -1;
      render();
      input.focus();
    }

    input.addEventListener('focus', open);
    input.addEventListener('input', function () {
      activeIndex = -1;
      open();
    });
    input.addEventListener('blur', function () {
      // 候補のクリック（mousedown）を処理してから閉じる
      setTimeout(close, 120);
    });
    input.addEventListener('keydown', function (e) {
      var items = candidates();
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        open();
        activeIndex = Math.min(activeIndex + 1, items.length - 1);
        renderList();
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIndex = Math.max(activeIndex - 1, 0);
        renderList();
      } else if (e.key === 'Enter') {
        // フォーム送信ではなく候補の追加にする
        e.preventDefault();
        var target = items[activeIndex >= 0 ? activeIndex : 0];
        if (target) {
          add(target);
        }
      } else if (e.key === 'Backspace' && input.value === '') {
        var selected = selectedOptions();
        var last = selected[selected.length - 1];
        if (last) {
          last.selected = false;
          render();
        }
      } else if (e.key === 'Escape') {
        close();
      }
    });
    box.addEventListener('click', function (e) {
      if (e.target === box) {
        input.focus();
      }
    });

    render();
  }

  /**
   * 進化欄のプルダウンで「その他(手入力)」を選んだ時だけ、手入力欄を出す。
   * 一覧に無い保存値（"1,8" のような複合値など）を壊さないための逃げ道。
   */
  function enhanceEvolutionSelect(select) {
    var wrapper = document.querySelector(
      '[data-evolution-raw="' + select.dataset.evolutionSelect + '"]'
    );
    if (!wrapper) {
      return;
    }
    var other = select.dataset.evolutionOther || '_other';
    function sync() {
      wrapper.style.display = select.value === other ? '' : 'none';
    }
    select.addEventListener('change', sync);
    sync();
  }

  function init() {
    Array.prototype.slice
      .call(document.querySelectorAll('select[data-tagselect]'))
      .forEach(enhance);
    Array.prototype.slice
      .call(document.querySelectorAll('select[data-evolution-select]'))
      .forEach(enhanceEvolutionSelect);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
