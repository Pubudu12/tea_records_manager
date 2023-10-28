    let articleHTML = '';
    editorContent.blocks.map(obj => {
        switch (obj.type) {
            case 'paragraph':
                articleHTML += `<div class="ce-block">
                <div class="ce-block__content">
                    <div class="ce-paragraph cdx-block">
                    <p>${obj.data.text}</p>
                    </div>
                </div>
                </div>\n`;
            break;
        case 'image':
            articleHTML += `<div class="ce-block">
                    <div class="ce-block__content">
                        <div class="ce-image cdx-block">
                            <img src="${obj.data.url}" class="img-fluid img-responsive" alt="${obj.data.caption}" />
                            <div class="text-center">
                                <i>${obj.data.caption}</i>
                            </div>

                        </div>
                    </div>
                </div>\n`;
            break;
        case 'header':
            articleHTML += `<div class="ce-block">
            <div class="ce-block__content">
                <div class="ce-paragraph cdx-block">
                <h${obj.data.level}>${obj.data.text}</h${obj.data.level}>
                </div>
            </div>
            </div>\n`;
            break;
        case 'raw':
            articleHTML += `<div class="ce-block">
            <div class="ce-block__content">
            <div class="ce-code">
                <code>${obj.data.html}</code>
            </div>
            </div>
        </div>\n`;
            break;
        case 'code':
            articleHTML += `<div class="ce-block">
            <div class="ce-block__content">
                <div class="ce-code">
                <code>${obj.data.code}</code>
                </div>
            </div>
            </div>\n`;
            break;
        case 'list':
            if (obj.data.style === 'unordered') {
            const list = obj.data.items.map(item => {
                return `<li class="cdx-list__item">${item}</li>`;
            });
            articleHTML += `<div class="ce-block">
                <div class="ce-block__content">
                <div class="ce-paragraph cdx-block">
                    <ul class="cdx-list--unordered">${list.join('')}</ul>
                </div>
                </div>
                </div>\n`;
            } else {
            const list = obj.data.items.map(item => {
                return `<li class="cdx-list__item">${item}</li>`;
            });
            articleHTML += `<div class="ce-block">
                <div class="ce-block__content">
                <div class="ce-paragraph cdx-block">
                    <ol class="cdx-list--ordered">${ list.join('') }</ol>
                </div>
                </div>
                </div>\n`;
            }
            break;
        case 'delimeter':
            articleHTML += `<div class="ce-block">
            <div class="ce-block__content">
                <div class="ce-delimiter cdx-block"></div>
            </div>
            </div>\n`;
            break;

        case 'embed':
            articleHTML += `<div class="ce-block">
            <div class="ce-block__content">
                <div class="ce-embed cdx-block">
                    <embed src="${obj.data.embed}" width="100%" height="${obj.data.height}" type="">
                    <br>
                </div>
            </div>
            </div>\n`;
            break;
        default:
            return '';
        }
    });

    document.getElementById('editorContent').innerHTML = articleHTML;