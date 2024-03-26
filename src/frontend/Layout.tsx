import { Header } from "./Header";
import { NowPlaying } from "./NowPlaying/NowPlaying";

export function Layout() {
  return (
    <div className="grid h-screen w-full">
      <Header />
      <div className="overflow-y-auto px-4 py-8">
        <NowPlaying />
      </div>
    </div>
  );
}
