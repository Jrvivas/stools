class ModalManager{
    constructor(idModal){
        this.dom=document.querySelector('#'+idModel)

    }
    /**
     * insetar un body html
     * @param {string} htmlText 
     */
    setHtmlBody(htmlText){
        this.dom.innerHTML=htmlText;
    }
    setHtmlElement(idElement,htmlText){
        let element=document.querySelector('#'+idElement);
        if(element){
            element.innerHTML=htmlText
        }else{
            console.log('ERROR: ModalManager.setHtmlElement no se encontrón el elemento')
        }
        
    }
}
class Html{
   static addDiv(id,txtClass,content){
        return `<div id="${id}" class="${txtClass}">
                    ${content}
                </div>`;
    }
}