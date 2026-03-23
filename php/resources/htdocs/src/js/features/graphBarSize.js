/**
 * data-graph の表示域進入時に、紐づく要素の横幅／縦幅を data-graph-value の % で設定する
 * 0% から目標値まで徐々に伸ばすアニメーション付き
 * - data-graph: グラフ領域の識別子
 * - data-graph-type: "horizon" → 紐づく要素の横幅を % で指定 / "vertical" → 縦幅を % で指定
 * - data-graph-related: data-graph と同じ値の要素が、そのグラフに紐づく
 * - data-graph-value: 紐づく要素に指定する % 値（0〜100 など）
 */

/** 伸ばすアニメーションの時間（ミリ秒） */
const ANIMATION_DURATION = 800;

/**
 * 1つの data-graph 要素について、紐づく要素に幅をアニメーションで適用
 * @param {string} graphId - data-graph の値
 * @param {string} type - "horizon" | "vertical"
 * @param {HTMLElement|Document} root - 検索範囲
 */
const applyGraphSizes = (graphId, type, root) => {
	const scope = root instanceof Document ? document.body : root;
	const related = scope.querySelectorAll(`[data-graph-related="${graphId}"]`);

	const isHorizon = type === 'horizon';
	const prop = isHorizon ? 'width' : 'height';
	const transitionValue = `${prop} ${ANIMATION_DURATION}ms ease-out`;

	related.forEach((el) => {
		const valueAttr = el.getAttribute('data-graph-value');
		if (valueAttr === null || valueAttr === '') return;
		const value = Number(valueAttr);
		if (Number.isNaN(value)) return;

		const percent = `${Math.min(100, Math.max(0, value))}%`;

		el.style.transition = transitionValue;
		el.style[prop] = '0%';

		requestAnimationFrame(() => {
			requestAnimationFrame(() => {
				el.style[prop] = percent;
			});
		});
	});
};

/**
 * data-graph 要素を監視し、表示域に入ったら紐づく要素の幅を適用
 * @param {HTMLElement|Document} [container=document] - 検索対象
 */
export const initGraphBarSize = (container = document) => {
	const root = container instanceof Document ? document.body : container;
	const graphEls = root.querySelectorAll('[data-graph]');

	if (!graphEls.length) return;

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (!entry.isIntersecting) return;
				const el = entry.target;
				observer.unobserve(el);

				const graphId = el.getAttribute('data-graph');
				const type = el.getAttribute('data-graph-type');
				if (!graphId || !type) return;
				if (type !== 'horizon' && type !== 'vertical') return;

				applyGraphSizes(graphId, type, root);
			});
		},
		{ rootMargin: '0px', threshold: 0.1 }
	);

	graphEls.forEach((el) => observer.observe(el));
};
