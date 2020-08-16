const defaultDialog ={
    title:'',
    type:'',
    visible:false,
};
export default defaultDialog;

export function setDialog(dialog,options) {
    dialog=options?options:defaultDialog
}