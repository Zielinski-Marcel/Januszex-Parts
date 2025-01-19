import IconButton from "@/Components/IconButton.jsx";
import {useState} from "react";
import Show from "@/Components/Show.jsx";
import Checkbox from "@/Components/Checkbox.jsx";
import {useDetectClickOutside} from "react-detect-click-outside";

export default function FilterPanel({coowners, spendingsTypes, spendingSelectedCoowner, setSpendingSelectedCoowner, spendingSelectedType, setSpendingSelectedType}) {
    const [showFilterPanel, setFilterPanel] = useState(false);
    function handleCheckedCoowner(isChecked, coowner){
        setSpendingSelectedCoowner(coowners=>({...coowners, [coowner]: isChecked}))
    }

    function handleCheckedType(isChecked, type){
        setSpendingSelectedType(types=>({...types, [type]: isChecked}))
    }

    const ref = useDetectClickOutside({ onTriggered: ()=>setFilterPanel(false) });

    return (
        <div ref={ref}>
        <IconButton onClick={() => setFilterPanel(!showFilterPanel)} className="relative h-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 strokeWidth={2} stroke="currentColor" className="size-6">
                <path strokeLinecap="round" strokeLinejoin="round"
                      d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
            </svg>
            <Show when={showFilterPanel}>
                <div onClick={(e)=>e.stopPropagation()} className="absolute top-12 right-0 bg-white border-2 p-2 border-primary text-black rounded-md min-h-60 w-60 py-4">
                    <h2 className="text-base font-medium text-gray-900 mb-2">Filter Coowners</h2>
                    {coowners.map(coowner => (
                        <div key={coowner} className="flex gap-0 ml-1 p-0.5">
                            <Checkbox
                                className="rounded border-gray-300 text-emerald-500 focus:ring-emerald-500"
                                checked={spendingSelectedCoowner[coowner]}
                                onChange={(e) => handleCheckedCoowner(e.target.checked, coowner)}
                            />
                            <span className="ms-2 text-sm text-gray-600">
                                {coowner}
                            </span>
                        </div>
                    ))}
                    <h2 className="text-base font-medium text-gray-900 mb-2 border-t border-gray-200 mt-4 pt-2">Filter Types</h2>
                    {spendingsTypes.map(type => (
                        <div key={type} className="flex gap-0 ml-1 p-0.5">
                            <Checkbox
                                className="rounded border-gray-300 text-emerald-500 focus:ring-emerald-500"
                                checked={spendingSelectedType[type]}
                                onChange={(e) => handleCheckedType(e.target.checked, type)}
                            />
                            <span className="ms-2 text-sm text-gray-600">
                                {type}
                            </span>
                        </div>
                    ))}
                </div>
            </Show>
        </IconButton>
        </div>
    )
}
