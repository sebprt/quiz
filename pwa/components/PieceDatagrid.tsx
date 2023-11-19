import {Datagrid, useRecordContext} from "@api-platform/admin";
import { fetchUtils } from 'ra-core';

const apiUrl = 'https://localhost'; // Remplacez par l'URL de votre API
const httpClient = fetchUtils.fetchJson;

const PieceDatagrid = props => {
  const record = useRecordContext();
  if (!record) return null;

  console.log(record)
  const url = `${apiUrl}/puzzles/${record.id}/pieces`;
  const data = httpClient(url).then(({json}) => ({
    data: json,
  }));

  return (
   <div></div>
  )
};

export default PieceDatagrid
