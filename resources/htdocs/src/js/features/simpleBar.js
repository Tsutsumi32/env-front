/**
 * SimpleBar 初期化（UMD: window.SimpleBar）
 * footer で simplebar.min.js をモジュールより前に読み込むこと。
 *
 * HTML: 対象要素に .js-simplebar（data-simplebar は付けない＝自動二重初期化防止）
 *
 * data-simplebar-auto-hide="true" … デフォルトは false（常にサム表示寄り）
 */
const parseOptions = (el) => ({
	autoHide: el.dataset.simplebarAutoHide === 'true',
	clickOnTrack: el.dataset.simplebarClickOnTrack !== 'false',
	forceVisible: (() => {
		const v = (el.dataset.simplebarForceVisible || '').toLowerCase();
		if (v === 'x' || v === 'y') return v;
		if (v === 'true' || v === 'both') return true;
		return false;
	})(),
	scrollbarMinSize: el.dataset.simplebarScrollbarMinSize
		? Number(el.dataset.simplebarScrollbarMinSize)
		: undefined,
	scrollbarMaxSize: el.dataset.simplebarScrollbarMaxSize
		? Number(el.dataset.simplebarScrollbarMaxSize)
		: undefined
});

export function initSimpleBar(selector = '.js-simplebar') {
	const Ctor = typeof window !== 'undefined' ? window.SimpleBar : null;
	if (!Ctor) {
		console.warn(
			'[initSimpleBar] SimpleBar が未読込です。footer で simplebar.min.js をページ用 module より前に読み込んでください。'
		);
		return;
	}

	document.querySelectorAll(selector).forEach((el) => {
		if (el.dataset.simplebarInitialized === 'true') return;
		el.dataset.simplebarInitialized = 'true';

		const o = parseOptions(el);
		const options = {
			autoHide: o.autoHide,
			clickOnTrack: o.clickOnTrack
		};
		if (o.forceVisible !== false && o.forceVisible !== undefined) {
			options.forceVisible = o.forceVisible;
		}
		if (Number.isFinite(o.scrollbarMinSize)) {
			options.scrollbarMinSize = o.scrollbarMinSize;
		}
		if (Number.isFinite(o.scrollbarMaxSize)) {
			options.scrollbarMaxSize = o.scrollbarMaxSize;
		}

		new Ctor(el, options);
	});
}





.header-menu [data-simplebar] {
	.simplebar-track.simplebar-vertical {
		top: rem(6);
		bottom: rem(6);
		width: rem(8);
		background-color: rgba(colors(white), .22);
		border-radius: rem(999);
	}

	.simplebar-scrollbar:before {
		left: rem(2);
		right: rem(2);
		top: rem(2);
		bottom: rem(2);
		background-color: rgba(colors(white), .8);
		border-radius: rem(999);
		opacity: 1;
		transition: background-color .2s;
	}

	.simplebar-scrollbar.simplebar-visible:before {
		opacity: 1;
	}

	.simplebar-scrollbar:hover:before {
		background-color: colors(white);
	}
}
