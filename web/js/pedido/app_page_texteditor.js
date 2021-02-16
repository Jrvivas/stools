class TextEditor extends Page{
    static _pag_edit_text=`
            <div class="row" style="position: fixed;bottom: 5px;">
            <div class="col-xs-2">
                <button id="boton_cancelar_textedit" class="boton-float" style="left: 5px; background: red; width:42px; height: 42px;position: inherit; ">
                        <img src="assets/imgs/icon-cancel.svg" alt="X" style="width:24px"/>
                </button>
            </div>
            <div class="col-xs-8">
                 <textarea id="txtedit_text" style=" width:100%;height: 50px;background: #f5f5e4; border-radius: 5px; border: solid 1px gray;" placeholder="Escriba... ">
                 </textarea>
            </div>
            <div class="col-xs-2">
                <button id="boton_aceptar_textedit"  class="boton-float"  style="right: 15px; background: green; width:42px; height: 42px; position: inherit;">
                        <img src="assets/imgs/icon-aceptar.svg" alt="V" style="width: 24px"/>
                </button>
            
            </div> 
        </div>
            `
    constructor(nombre,visible=false){
        super(nombre,TextEditor._pag_edit_text,visible,function(){
            let me=this
            this.text='';
            if(this.props && this.props.text){
                this.text= this.props.text
            }

            $("#txtedit_text").val(this.text)
            
            $("#boton_aceptar_textedit").click(()=>{
                this.text=$("#txtedit_text").val()
                this.onClickAceptar()
            })
            $("#boton_cancelar_textedit").click(()=>{
                this.onClickCancel()
            })
            $("#txtedit_text").focus()
        })
        //this.text='' 
        
    }

    onClickAceptar=()=>{

    }
    onClickCancel=()=>{
        
    }
}