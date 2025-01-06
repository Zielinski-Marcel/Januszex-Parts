import {useForm} from "@inertiajs/react";

export default function addVehicle({userid}){
    const form = useForm();

    function submit(e){
        e.preventDefault();
        form.post(`/user/${userid}/vehicle`);
    }

    return(
    <div>
        <form onSubmit={submit}>
            <input type="text" name="brand" value={form.data.brand} onChange={e => form.setData('brand', e.target.value)}/>
            <input type="text" name="model"value={form.data.model} onChange={e => form.setData('model', e.target.value)}/>
            <input type="number" name="year_of_manufacture"value={form.data.year_of_manufacture} onChange={e => form.setData('year_of_manufacture', e.target.value)}/>
            <input type="text" name="fuel_type"value={form.data.fuel_type} onChange={e => form.setData('fuel_type', e.target.value)}/>
            <input type="number" name="purchase_date"value={form.data.purchase_date} onChange={e => form.setData('purchase_date', e.target.value)}/>
            <input type="text" name="color"value={form.data.color} onChange={e => form.setData('color', e.target.value)}/>
<button type="submit">Wyślij</button>

        </form>
    </div>
    )

}
