export function getCurrentDate(){
    const date = new Date();
    const month = date.getMonth() + 1;

    return `${date.getFullYear()}-${month > 9 ?month : "0" + month.toString()}-${date.getDate()}`
}
