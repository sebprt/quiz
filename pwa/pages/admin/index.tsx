import Head from "next/head";
import { useEffect, useState } from "react";
import {ResourceGuesser} from "@api-platform/admin";
import PuzzleList from "../../components/PuzzleList";
import ExtensionIcon from '@mui/icons-material/Extension';
import MapIcon from '@mui/icons-material/Map';
import EventIcon from '@mui/icons-material/Event';
import LibraryMusicIcon from '@mui/icons-material/LibraryMusic';
import TranslateIcon from '@mui/icons-material/Translate';
import {AdminLayout} from "../../components/AdminLayout";
import PuzzleShow from "../../components/PuzzleShow";

const Admin = () => {
  // Load the admin client-side
  const [DynamicAdmin, setDynamicAdmin] = useState(<p>Loading...</p>);
  useEffect(() => {
    (async () => {
      const HydraAdmin = (await import("@api-platform/admin")).HydraAdmin;

      setDynamicAdmin(
        <HydraAdmin entrypoint={window.origin} layout={AdminLayout}>
          <ResourceGuesser name="events" icon={EventIcon} />
          <ResourceGuesser name="puzzles" list={PuzzleList} show={PuzzleShow} icon={ExtensionIcon} />
          <ResourceGuesser name="maps" icon={MapIcon} />
          <ResourceGuesser name="sentences" icon={TranslateIcon}  />
          <ResourceGuesser name="songs" icon={LibraryMusicIcon} />
        </HydraAdmin>
      );
    })();
  }, []);

  return (
    <>
      <Head>
        <title>API Platform Admin</title>
      </Head>

      {DynamicAdmin}
    </>
  );
};
export default Admin;
