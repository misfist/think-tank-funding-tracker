(()=>{"use strict";const t=window.wp.blocks,e=window.wp.i18n,n=window.wp.blockEditor,c=window.wp.components;const r=JSON.parse('{"UU":"ttft/search-form"}');(0,t.registerBlockType)(r.UU,{edit:function(t){var r=t.attributes.description,o=t.setAttributes;return React.createElement(React.Fragment,null,React.createElement(n.InspectorControls,null,React.createElement(c.PanelBody,{title:(0,e.__)("Search Settings","ttft")},React.createElement(c.TextControl,{label:(0,e.__)("Description","ttft"),value:r||"",onChange:function(t){return o({description:t})}}))),React.createElement("div",(0,n.useBlockProps)(),React.createElement(c.Dashicon,{icon:"search"})," ",r||(0,e.__)("Search Form","ttft")))}})})();