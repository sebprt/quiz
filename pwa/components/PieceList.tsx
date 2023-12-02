import {useGetRecordId} from 'react-admin';
import {useEffect, useState} from 'react';
import {fetchUtils, ReferenceManyField} from 'react-admin';
import { DataGrid, GridColDef, GridValueGetterParams } from '@mui/x-data-grid';

const fetchJson = async (url, options = {}) => {
  if (!options.headers) {
    options.headers = new Headers({Accept: 'application/ld+json'});
  }

  return await fetchUtils.fetchJson(url, options);
};

const PieceList = props => {
  const recordId = useGetRecordId();
  const [pieces, setPieces] = useState([]);

  useEffect(() => {
    fetchJson(`${recordId}/pieces`)
      .then(response => response.json)
      .then(data => setPieces(data.pieces))
  }, [recordId]);

  console.log(pieces)

  return (
    <DataGrid
      rows={pieces}
      pageSize={5}
      checkboxSelection
      disableSelectionOnClick
    />
  )
};

export default PieceList
