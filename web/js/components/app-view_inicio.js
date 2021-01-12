export class ViewRegister{
    constructor(props){
        super(props)
            this.state={
                user:this.props.user
            }
        
    }

    render(){
        let helpNombre='Escriba su nombre (Apellido Nombre)'
        let helpEmail='Escriba su email donde podamos enviar la verificación de su registro'
        let helpUser='Escriba un nombre de usuario con almenos 8 letras que usará para ingresar a sus aplicaciones'
        let helpClave='Escriba y recuerde una clave para su ingreso, que tenga almenos 8 letras o numeros'
        let helpConfClave='Repita la clave anterior para evitar error de escritura'
        let textofinal='Falta poco complete los datos pedidos arriba'
        return(
            <div>
                <Saludo user={this.state.user}/>
                <Avatar user={this.state.user}/>
                <InputTextInfo setText={this.changeNombreHandle} info={helpNombre} requerido={true} />
                <InputEmailInfo setText={this.changeEmailHandle} info={helpEmail}  requerido={true} />
                <InputUserNameInfo setText={this.changeUserHandle} info={helpUser}  requerido={true} />
                <InputUserPasswordInfo setText={this.changePasswHandle} info={helpClave}  requerido={true} />
                <InputUserPasswordInfo setText={this.changePasswHandle} info={helpConfClave}  requerido={true} />
                <TextComentario  texto={textofinal}/>
            </div>
        )
        
      }
}