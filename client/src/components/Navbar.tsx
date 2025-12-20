import { useTranslation } from "@/contexts/LocalizationContext";
import { useAuth } from "@/_core/hooks/useAuth";
import { Button } from "@/components/ui/button";
import { Link } from "wouter";
import { getLoginUrl } from "@/const";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

export default function Navbar() {
  const { t, locale, setLocale } = useTranslation();
  const { isAuthenticated, logout } = useAuth();

  return (
    <nav className="border-b border-border bg-background sticky top-0 z-50">
      <div className="container mx-auto px-4 py-4 flex items-center justify-between">
        <Link href="/" className="text-xl font-bold text-foreground hover:opacity-80">
          {t("nav.products")}
        </Link>

        <div className="flex items-center gap-4">
          <Link href="/" className="text-foreground hover:text-primary">
            {t("nav.home")}
          </Link>
          <Link href="/products" className="text-foreground hover:text-primary">
            {t("nav.products")}
          </Link>
          <Link href="/create" className="text-foreground hover:text-primary">
            {t("nav.addProduct")}
          </Link>

          <Select value={locale} onValueChange={(value: any) => setLocale(value)}>
            <SelectTrigger className="w-[100px]">
              <SelectValue />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="en">English</SelectItem>
              <SelectItem value="ar">العربية</SelectItem>
            </SelectContent>
          </Select>

          {isAuthenticated ? (
            <Button onClick={logout} variant="outline">
              Logout
            </Button>
          ) : (
            <Button onClick={() => (window.location.href = getLoginUrl())}>
              Login
            </Button>
          )}
        </div>
      </div>
    </nav>
  );
}
