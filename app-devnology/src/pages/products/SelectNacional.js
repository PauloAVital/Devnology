const SelectNacional = ({user}) => {
    
    const categoria = [];

    {user?.map((users, index) => (
        categoria.push(users.categoria)
    ))}
    const uniqueCategoria = categoria.filter((val, id, array) => {
        return categoria.indexOf(val) == id;  
     });

    return (
        <>
        {uniqueCategoria?.sort((a,b) => a?.localeCompare(b)).map((uniqueCategoria, index) => 
            <option key={index} value={uniqueCategoria}>{uniqueCategoria}</option>
        )}
        <option key='0' value=''>Todos Produtos</option>
        </>
    )
}

export default SelectNacional