import { useTranslation } from "@/contexts/LocalizationContext";
import { Button } from "@/components/ui/button";
import { Link } from "wouter";

export default function Home() {
  const { t } = useTranslation();

  return (
    <div className="min-h-screen flex flex-col">
      <main className="flex-1 flex items-center justify-center">
        <div className="text-center space-y-6">
          <h1 className="text-4xl font-bold text-foreground">
            {t("home.title")}
          </h1>
          <p className="text-xl text-muted-foreground">
            {t("home.description")}
          </p>
          <div className="flex gap-4 justify-center">
            <Link href="/products">
              <Button size="lg">{t("nav.products")}</Button>
            </Link>
            <Link href="/create">
              <Button size="lg" variant="outline">
                {t("nav.addProduct")}
              </Button>
            </Link>
          </div>
        </div>
      </main>
    </div>
  );
}
