export const renderDiviFont = (props, slug, selector) => {
    if (props[slug]) {
        let fontFamily = {
                divi: 'ETmodules !important',
                fa: 'FontAwesome!important',
            },
            icon = props[slug] ? props[slug].split('|') : [],
            additionalCss = [];

        additionalCss.push([
            {
                selector,
                declaration: `
                font-family: ${fontFamily[icon[2]]};
                font-weight: ${icon[4]}!important;`,
            },
        ]);
        return additionalCss;
    }

    return [];
};
