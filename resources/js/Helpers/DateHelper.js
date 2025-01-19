export function getCurrentDate(){
    const date = new Date();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    return `${date.getFullYear()}-${month > 9 ?month : "0" + month.toString()}-${day > 9 ?day : "0" + day.toString()}`
}
